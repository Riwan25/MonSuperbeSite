document.getElementById('myValidatedForm').addEventListener('submit', function(event) {
    
    let isValid = true;

    const prenomInput = document.getElementById('prenom');
    const errorMessagePrenom = document.getElementById('errorMessagePrenom');
    
    const emailInput = document.getElementById('mail');
    const errorMessageEmail = document.getElementById('errorMessageEmail');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (prenomInput.value.trim() === '') {
        isValid = false;
        prenomInput.classList.add('input-error');
        prenomInput.classList.remove('input-valid');
        errorMessagePrenom.textContent = "Le prénom est obligatoire.";
        errorMessagePrenom.classList.remove('hidden');
    } else {
        prenomInput.classList.remove('input-error');
        prenomInput.classList.add('input-valid');
        errorMessagePrenom.classList.add('hidden');
    }
    if (emailInput.value.trim() === '' || !emailRegex.test(emailInput.value.trim())) {
        isValid = false;
        emailInput.classList.add('input-error');
        errorMessageEmail.classList.remove('input-valid');
        errorMessageEmail.textContent = "Le mail est obligatoire.";
        errorMessageEmail.classList.remove('hidden');
    } else {
        emailInput.classList.remove('input-error');
        emailInput.classList.add('input-valid');
        errorMessageEmail.classList.add('hidden');
    }
    if (!isValid) {
        event.preventDefault();
    }
});
