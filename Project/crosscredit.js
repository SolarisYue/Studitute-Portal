// JavaScript code to compare document groups
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('compareButton').addEventListener('click', compareDocumentGroups);
});

async function compareDocumentGroups() {
    const filesGroup1 = document.getElementById('fileGroup1').files;
    const filesGroup2 = document.getElementById('fileGroup2').files;

    if (filesGroup1.length === 0 || filesGroup2.length === 0) {
        alert("Please upload files in both groups.");
        return;
    }

    const textsGroup1 = await extractTexts(filesGroup1);
    const textsGroup2 = await extractTexts(filesGroup2);

    const bestMatches = textsGroup1.map(text1 => ({
        file1: text1,
        file2: { name: '', url: '', similarity: -1 }
    }));

    for (const text1 of textsGroup1) {
        for (const text2 of textsGroup2) {
            const cleanedText1 = cleanText(text1.text);
            const cleanedText2 = cleanText(text2.text);

            const similarity = calculateCosineSimilarity(cleanedText1, cleanedText2) * 100;
            const text1Index = bestMatches.findIndex(match => match.file1.name === text1.name);
            if (similarity > bestMatches[text1Index].file2.similarity) {
                bestMatches[text1Index].file2 = { name: text2.name, url: text2.url, similarity: similarity.toFixed(2) };
            }
        }
    }

    const filteredMatches = bestMatches.filter(match => parseFloat(match.file2.similarity) >= 80);
    sessionStorage.setItem('comparisonResults', JSON.stringify(filteredMatches));
    window.location.href = 'results.html';
}

async function extractTexts(files) {
    const texts = [];
    for (let file of files) {
        const text = await extractText(file);
        const dataUrl = await readFileAsDataURL(file);
        const fileNameWithoutExtension = file.name.replace('.docx', '');
        texts.push({ name: fileNameWithoutExtension, text: text, url: dataUrl });
    }
    return texts;
}

async function extractText(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = function(event) {
            const arrayBuffer = event.target.result;
            mammoth.extractRawText({ arrayBuffer: arrayBuffer })
                .then(result => {
                    resolve(result.value);
                })
                .catch(err => {
                    reject(err);
                });
        };
        reader.onerror = () => {
            reject("Failed to read file");
        };
        reader.readAsArrayBuffer(file);
    });
}

function readFileAsDataURL(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = function(event) {
            resolve(event.target.result);
        };
        reader.onerror = () => {
            reject("Failed to read file");
        };
        reader.readAsDataURL(file);
    });
}

function cleanText(text) {
    return text.trim().toLowerCase().replace(/\s+/g, ' ');
}

function calculateCosineSimilarity(text1, text2) {
    const words1 = tokenize(text1);
    const words2 = tokenize(text2);
    const wordSet = new Set([...words1, ...words2]);
    const vector1 = getTFIDFVector(words1, wordSet);
    const vector2 = getTFIDFVector(words2, wordSet);
    return cosineSimilarity(vector1, vector2);
}

function tokenize(text) {
    return text.split(' ').filter(word => word.length > 0);
}

function termFrequency(word, words) {
    const count = words.filter(w => w === word).length;
    return count / words.length;
}

function getTFIDFVector(words, wordSet) {
    const tfidfVector = [];
    wordSet.forEach(word => {
        const tf = termFrequency(word, words);
        tfidfVector.push(tf);
    });
    return tfidfVector;
}

function cosineSimilarity(vectorA, vectorB) {
    const dotProduct = vectorA.reduce((sum, a, i) => sum + a * vectorB[i], 0);
    const magnitudeA = Math.sqrt(vectorA.reduce((sum, val) => sum + val * val, 0));
    const magnitudeB = Math.sqrt(vectorB.reduce((sum, val) => sum + val * val, 0));
    if (magnitudeA === 0 || magnitudeB === 0) return 0;
    return dotProduct / (magnitudeA * magnitudeB);
}