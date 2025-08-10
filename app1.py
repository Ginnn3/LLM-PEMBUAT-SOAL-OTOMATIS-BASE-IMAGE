from flask import Flask, request, jsonify
import requests
import base64
import mimetypes

app = Flask(__name__)

LLAVA_URL = "http://192.168.0.108:1234/v1/chat/completions"
LLAMA_URL = "http://192.168.0.108:1234/v1/chat/completions"

def encode_image_base64(image_file):
    image_bytes = image_file.read()
    image_b64 = base64.b64encode(image_bytes).decode('utf-8')
    mime_type = mimetypes.guess_type(image_file.filename)[0] or 'image/png'
    return f"data:{mime_type};base64,{image_b64}"

def call_llava_describe(image_data_url):
    prompt = "Describe the contents of this image clearly and briefly in English."
    payload = {
        "model": "llava-v1.5-7b",
        "messages": [{
            "role": "user",
            "content": [
                {"type": "text", "text": prompt},
                {"type": "image_url", "image_url": {"url": image_data_url}}
            ]
        }],
        "temperature": 0.4,
        "max_tokens": 512
    }
    response = requests.post(LLAVA_URL, json=payload)
    response.raise_for_status()
    return response.json()["choices"][0]["message"]["content"].strip()

def call_llama_question(desc, question_type):
    if question_type == "easy":
        prompt = f"""
IMPORTANT: Use ONLY English for all output.

Create a multiple-choice question in English based on the following description:

Description: {desc}

1. Create 1 multiple-choice question based on the description.
2. Provide 4 answer options (a, b, c, d).
3. Indicate the correct answer and give an explanation.

Format:
1. Description: ...
2. Question: ...
   a. ...
   b. ...
   c. ...
   d. ...
3. Answer: ...
4. Explanation: ...
""".strip()

    elif question_type == "medium":
        prompt = f"""
IMPORTANT: Use ONLY English for all output.

Create a short-answer question in English based on the following description.

Description: {desc}

Instructions:
1. Write 1 short question that has a specific answer based on the description.
2. The question must start with a question word (e.g. What, Where, When, Who, Why, or How).
3. Provide the correct answer.
4. Provide a brief explanation of the answer.

Format:
1. Description: ...
2. Question: ...
3. Answer: ...
4. Explanation: ...
""".strip()

    elif question_type == "hard":
        prompt = f"""
IMPORTANT: Use ONLY English for all output.

Create an essay question in English based on the following description:

Description: {desc}

1. Create an essay question that asks for analysis or explanation.
2. Provide a sample answer.
3. Briefly explain why the answer is correct.

Format:
1. Description: ...
2. Question: ...
3. Answer: ...
4. Explanation: ...
""".strip()

    else:
        raise ValueError("Invalid question type.")

    payload = {
        "model": "meta-llama-3.1-8b-instruct",
        "messages": [{"role": "user", "content": prompt}],
        "temperature": 0.3,
        "max_tokens": 1024
    }
    response = requests.post(LLAMA_URL, json=payload)
    response.raise_for_status()
    return response.json()["choices"][0]["message"]["content"].strip()

# ========== ENDPOINT EASY ==========
@app.route('/analyze-image-easy', methods=['POST'])
def analyze_easy():
    if 'image' not in request.files:
        return jsonify({'error': 'No image provided'}), 400
    image = request.files['image']
    image_data_url = encode_image_base64(image)

    try:
        description = call_llava_describe(image_data_url)
        question = call_llama_question(description, "easy")
        return jsonify({"description": description, "question": question})
    except Exception as e:
        return jsonify({"error": str(e)}), 500

# ========== ENDPOINT MEDIUM ==========
@app.route('/analyze-image-medium', methods=['POST'])
def analyze_medium():
    if 'image' not in request.files:
        return jsonify({'error': 'No image provided'}), 400
    image = request.files['image']
    image_data_url = encode_image_base64(image)

    try:
        description = call_llava_describe(image_data_url)
        question = call_llama_question(description, "medium")
        return jsonify({"description": description, "question": question})
    except Exception as e:
        return jsonify({"error": str(e)}), 500

# ========== ENDPOINT HARD ==========
@app.route('/analyze-image-hard', methods=['POST'])
def analyze_hard():
    if 'image' not in request.files:
        return jsonify({'error': 'No image provided'}), 400
    image = request.files['image']
    image_data_url = encode_image_base64(image)

    try:
        description = call_llava_describe(image_data_url)
        question = call_llama_question(description, "hard")
        return jsonify({"description": description, "question": question})
    except Exception as e:
        return jsonify({"error": str(e)}), 500

# ========== RUN ==========
if __name__ == '__main__':
    import sys
    port = int(sys.argv[1]) if len(sys.argv) > 1 else 5000
    app.run(host='0.0.0.0', port=port, debug=False)
