from flask import Flask, request, jsonify
import requests
import base64
import mimetypes

app = Flask(__name__)

# URL LM Studio
LM_STUDIO_API_URL = "http://192.168.0.108:1234/v1/chat/completions"

# Fungsi untuk encode gambar ke base64 data URL
def encode_image_base64(image_file):
    image_bytes = image_file.read()
    image_b64 = base64.b64encode(image_bytes).decode('utf-8')
    mime_type = mimetypes.guess_type(image_file.filename)[0] or 'image/png'
    return f"data:{mime_type};base64,{image_b64}"

# Endpoint Soal Pilihan Ganda (Easy)
@app.route('/analyze-image-easy', methods=['POST'])
def analyze_image_easy():
    if 'image' not in request.files:
        return jsonify({'error': 'No image file provided'}), 400

    image_file = request.files['image']
    if image_file.filename == '':
        return jsonify({'error': 'No selected file'}), 400

    image_data_url = encode_image_base64(image_file)

    prompt = """
Lihat gambar berikut ini buat soal dalam bahasa inggris.

1. Deskripsikan isi gambar dengan jelas.
2. Buat satu soal pilihan ganda berdasarkan gambar tersebut.
3. Sediakan 3 pilihan jawaban (a, b, c) dan hanya satu jawaban yang benar.
4. Tunjukkan jawaban yang benar dan beri penjelasan mengapa benar.

Format hasil:
1. Deskripsi: (dalam bahasa inggris)
...
2. Soal: (dalam bahasa inggris)
...
   a. ...
   b. ...
   c. ...
3. Jawaban: (dalam bahasa inggris)
...
4. Penjelasan: (dalam bahasa inggris)
...
""".strip()

    payload = {
        "model": "llava-v1.5-7b",
        "messages": [
            {
                "role": "user",
                "content": [
                    {"type": "text", "text": prompt},
                    {"type": "image_url", "image_url": {"url": image_data_url}}
                ]
            }
        ],
        "temperature": 0.7,
        "max_tokens": 1024
    }

    try:
        response = requests.post(LM_STUDIO_API_URL, json=payload)
        response.raise_for_status()
        data = response.json()
        result = data.get("choices", [{}])[0].get("message", {}).get("content", "No response")
        return jsonify({"question": result})
    except requests.exceptions.RequestException as e:
        return jsonify({"error": str(e)}), 500


# Endpoint Soal Isian Singkat (Medium)
@app.route('/analyze-image-medium', methods=['POST'])
def analyze_image_medium():
    if 'image' not in request.files:
        return jsonify({'error': 'No image file provided'}), 400

    image_file = request.files['image']
    if image_file.filename == '':
        return jsonify({'error': 'No selected file'}), 400

    image_data_url = encode_image_base64(image_file)

    prompt = """
Lihat gambar ini dan buat 1 soal isian singkat dalam bahasa inggris.

Instruksi:
- Buat 1 kalimat pendek berdasarkan isi gambar.
- Pilih 1 kata penting di tengah kalimat dan gantilah dengan bagian kosong yang terlihat, gunakan garis bawah seperti ini: ? atau titik-titik seperti ini: ........
- Kalimat harus tetap masuk akal meskipun satu kata hilang.
- Setelah soal, berikan jawaban yang benar untuk bagian kosong.

Format:
SOAL: SOAL (TITIK TITIK) LANJUT SOAL
JAWABAN: [kata yang tepat jawab soal]

Contoh soal:
SOAL: Anak itu sedang memegang sebuah ..?.. di taman.
JAWABAN: balon

BUATKAN FORMAT HASIL GENERATE SEPERTI YANG SUDAH DI PAPARKAN
""".strip()

    payload = {
        "model": "llava-v1.5-7b",
        "messages": [
            {
                "role": "user",
                "content": [
                    {"type": "text", "text": prompt},
                    {"type": "image_url", "image_url": {"url": image_data_url}}
                ]
            }
        ],
        "temperature": 0.3,
        "max_tokens": 1024,
        "top_p": 1.0,
        "stop": None
    }

    try:
        response = requests.post(LM_STUDIO_API_URL, json=payload)
        response.raise_for_status()
        data = response.json()
        result = data.get("choices", [{}])[0].get("message", {}).get("content", "No response")
        return jsonify({"question": result})
    except requests.exceptions.RequestException as e:
        return jsonify({"error": str(e)}), 500


# Endpoint Soal Esai (Hard)
@app.route('/analyze-image-hard', methods=['POST'])
def analyze_image_hard():
    if 'image' not in request.files:
        return jsonify({'error': 'No image file provided'}), 400

    image_file = request.files['image']
    if image_file.filename == '':
        return jsonify({'error': 'No selected file'}), 400

    image_data_url = encode_image_base64(image_file)

    prompt = """
Lihat gambar berikut ini.

1. Deskripsikan isi gambar dengan jelas.
2. Buat satu soal jenis esai yang meminta peserta menjelaskan, menceritakan, atau menganalisis sesuatu berdasarkan gambar.
3. Soal harus menghasilkan jawaban terbuka yang bersifat deskriptif atau analitis.
4. Tulis satu contoh jawaban yang baik dan sesuai.
5. Jelaskan secara singkat mengapa jawaban contoh tersebut tepat.

Format hasil:
1. Deskripsi: (dalam bahasa inggris)
...
2. Soal (Esai): (dalam bahasa inggris)
...
3. Contoh Jawaban: (dalam bahasa inggris)
...
4. Penjelasan: (dalam bahasa inggris)
...
""".strip()

    payload = {
        "model": "llava-v1.5-7b",
        "messages": [
            {
                "role": "user",
                "content": [
                    {"type": "text", "text": prompt},
                    {"type": "image_url", "image_url": {"url": image_data_url}}
                ]
            }
        ],
        "temperature": 0.3,
        "max_tokens": 512
    }

    try:
        response = requests.post(LM_STUDIO_API_URL, json=payload)
        response.raise_for_status()
        data = response.json()
        result = data.get("choices", [{}])[0].get("message", {}).get("content", "No response")
        return jsonify({"question": result})
    except requests.exceptions.RequestException as e:
        return jsonify({"error": str(e)}), 500


# Jalankan app Flask
if __name__ == '__main__':
    import sys
    port = int(sys.argv[1]) if len(sys.argv) > 1 else 5000
    app.run(host='0.0.0.0', port=port, debug=False)
