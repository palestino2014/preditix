document.addEventListener('DOMContentLoaded', function() {
    // Validação de formulários
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = 'red';
                    isValid = false;
                } else {
                    field.style.borderColor = '';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Por favor, preencha todos os campos obrigatórios.');
            }
        });
    });
    
    // Preview de imagens antes do upload
    const fileInputs = document.querySelectorAll('input[type="file"][accept="image/*"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                const previewContainer = this.nextElementSibling;
                
                if (previewContainer && previewContainer.tagName === 'IMG') {
                    reader.onload = function(e) {
                        previewContainer.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    const img = document.createElement('img');
                    img.width = 100;
                    img.alt = 'Preview';
                    
                    reader.onload = function(e) {
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    
                    this.parentNode.appendChild(img);
                }
            }
        });
    });
    
    // Mensagens de alerta com timeout
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
});