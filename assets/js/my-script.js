function setupFileUpload(inputId, messageId, imageId) {
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById(inputId);
        const message = document.getElementById(messageId);
        const imagePreview = document.getElementById(imageId);

        fileInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                validateFileSize(file, message);
                previewImage(file, imagePreview);
            }
        });

        function validateFileSize(file, messageElement) {
            if (file.size > 50 * 1024) {
                messageElement.textContent = 'File size exceeds 50KB. file too large.';
                fileInput.value = ''; // Clear the file input
                clearImagePreview(imagePreview);
            }
            else{
                messageElement.textContent ='';
            } 
        }

        function previewImage(file, imageElement) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imageElement.src = e.target.result;
                imageElement.alt = file.name;
            };
            reader.readAsDataURL(file);
        }
    });
}

setupFileUpload('fileInput', 'lmsg1', 'image');
setupFileUpload('signInput', 'lmsg2', 'imgsign');
setupFileUpload('gsignInput', 'lmsg3', 'gimgsign');

