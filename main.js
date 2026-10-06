// JavaScript for client-side form validation 
// Checks whether required form fields have been filled in before allowing the form to be submitted

document.addEventListener("DOMContentLoaded", function () {
  var forms = document.querySelectorAll("form.validate");

  forms.forEach(function (form) {
    form.addEventListener("submit", function (event) {
      var requiredFields = form.querySelectorAll("[required]");
      var isValid = true;

      requiredFields.forEach(function (field) {
        if (field.value.trim() === "") {
          isValid = false;
        }
      });

      // Extra check just for the register form: passwords must match
      var password = form.querySelector('[name="password"]');
      var confirmPassword = form.querySelector('[name="confirm_password"]');
      if (password && confirmPassword && password.value !== confirmPassword.value) {
        isValid = false;
        alert("Passwords do not match.");
      }

      if (!isValid) {
        event.preventDefault();
        alert("Please fill in all required fields.");
      }
    });
  });
});
