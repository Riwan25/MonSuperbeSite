document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('userForm');

    if (!form) return;

    const firstname = document.getElementById('firstname');
    const lastname = document.getElementById('lastname');
    const email = document.getElementById('email');
    const genderInputs = document.querySelectorAll('input[name="gender"]');
    const birthdate = document.getElementById('birthdate');

    const errorFirstname = document.getElementById('error-firstname');
    const errorLastname = document.getElementById('error-lastname');
    const errorEmail = document.getElementById('error-email');
    const errorGender = document.getElementById('error-gender');
    const errorBirthdate = document.getElementById('error-birthdate');

    function validateFirstname() {
        const value = firstname.value.trim();
        const nameRegex = /^[a-zA-ZÀ-ÿ\s'-]{2,50}$/;

        if (value === '') {
            showError(firstname, errorFirstname, 'Le prénom est obligatoire.');
            return false;
        } else if (!nameRegex.test(value)) {
            showError(
                firstname,
                errorFirstname,
                'Le prénom doit contenir entre 2 et 50 caractères alphabétiques.'
            );
            return false;
        } else {
            clearError(firstname, errorFirstname);
            return true;
        }
    }

    function validateLastname() {
        const value = lastname.value.trim();
        const nameRegex = /^[a-zA-ZÀ-ÿ\s'-]{2,50}$/;

        if (value === '') {
            showError(lastname, errorLastname, 'Le nom est obligatoire.');
            return false;
        } else if (!nameRegex.test(value)) {
            showError(
                lastname,
                errorLastname,
                'Le nom doit contenir entre 2 et 50 caractères alphabétiques.'
            );
            return false;
        } else {
            clearError(lastname, errorLastname);
            return true;
        }
    }

    function validateEmail() {
        const value = email.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (value === '') {
            showError(email, errorEmail, "L'email est obligatoire.");
            return false;
        } else if (!emailRegex.test(value)) {
            showError(email, errorEmail, "L'email n'est pas valide.");
            return false;
        } else {
            clearError(email, errorEmail);
            return true;
        }
    }

    function validateGender() {
        let isChecked = false;
        genderInputs.forEach((input) => {
            if (input.checked) {
                isChecked = true;
            }
        });

        if (!isChecked) {
            errorGender.textContent = 'Veuillez sélectionner un genre.';
            return false;
        } else {
            errorGender.textContent = '';
            return true;
        }
    }

    function validateBirthdate() {
        const value = birthdate.value;

        if (value === '') {
            showError(
                birthdate,
                errorBirthdate,
                'La date de naissance est obligatoire.'
            );
            return false;
        }

        const birthDate = new Date(value);
        const today = new Date();

        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();

        if (
            monthDiff < 0 ||
            (monthDiff === 0 && today.getDate() < birthDate.getDate())
        ) {
            age--;
        }

        if (isNaN(birthDate.getTime())) {
            showError(
                birthdate,
                errorBirthdate,
                "La date de naissance n'est pas valide."
            );
            return false;
        } else if (age < 10) {
            showError(
                birthdate,
                errorBirthdate,
                'Vous devez avoir au moins 10 ans.'
            );
            return false;
        } else if (age > 99) {
            showError(
                birthdate,
                errorBirthdate,
                "L'âge ne peut pas dépasser 99 ans."
            );
            return false;
        } else if (birthDate > today) {
            showError(
                birthdate,
                errorBirthdate,
                'La date de naissance ne peut pas être dans le futur.'
            );
            return false;
        } else {
            clearError(birthdate, errorBirthdate);
            return true;
        }
    }

    function showError(input, errorElement, message) {
        input.classList.add('invalid');
        errorElement.textContent = message;
    }

    function clearError(input, errorElement) {
        input.classList.remove('invalid');
        errorElement.textContent = '';
    }

    if (firstname) {
        firstname.addEventListener('blur', validateFirstname);
        firstname.addEventListener('input', function () {
            if (this.classList.contains('invalid')) {
                validateFirstname();
            }
        });
    }

    if (lastname) {
        lastname.addEventListener('blur', validateLastname);
        lastname.addEventListener('input', function () {
            if (this.classList.contains('invalid')) {
                validateLastname();
            }
        });
    }

    if (email) {
        email.addEventListener('blur', validateEmail);
        email.addEventListener('input', function () {
            if (this.classList.contains('invalid')) {
                validateEmail();
            }
        });
    }

    if (genderInputs.length > 0) {
        genderInputs.forEach((input) => {
            input.addEventListener('change', validateGender);
        });
    }

    if (birthdate) {
        birthdate.addEventListener('blur', validateBirthdate);
        birthdate.addEventListener('change', validateBirthdate);
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const isFirstnameValid = validateFirstname();
        const isLastnameValid = validateLastname();
        const isEmailValid = validateEmail();
        const isGenderValid = validateGender();
        const isBirthdateValid = validateBirthdate();
        if (
            isFirstnameValid &&
            isLastnameValid &&
            isEmailValid &&
            isGenderValid &&
            isBirthdateValid
        ) {
            form.submit();
        } else {
            const firstError = form.querySelector('.invalid');
            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                });
                firstError.focus();
            }
        }
    });
});