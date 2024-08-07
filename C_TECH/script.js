function formatPhoneNumber(input) {
    // Remove all non-digit characters
    let value = input.value.replace(/\D/g, '');

    // Add dashes at appropriate positions
    if (value.length > 3) {
        value = value.slice(0, 3) + '-' + value.slice(3);
    }
    if (value.length > 7) {
        value = value.slice(0, 7) + '-' + value.slice(7);
    }

    // Limit the length to 12 characters (including dashes)
    input.value = value.slice(0, 12);
}



// 



//