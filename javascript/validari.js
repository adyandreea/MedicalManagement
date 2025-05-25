function validateForm(id) {
    const form = document.getElementById(id);
    if (!form) return true; 

    const inputs = form.querySelectorAll("input.required, select.required");

    for (const input of inputs) {
        if (input.value.trim() === "") {
            let numeCamp = input.placeholder || input.name || 'acest câmp';
            alert("Te rugăm să completezi: " + numeCamp);
            input.focus();
            return false;
        }
    }

    form.submit();
    return true;
}
