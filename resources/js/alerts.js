exports.errors = (errors) => {
    let templateErrors = `<ul>`;
    
    for (const key in errors) {
        if (errors.hasOwnProperty(key)) {
            const element = errors[key];        
            templateErrors += `<li>${errors[key]}</li>`;
        }
    }

    templateErrors += `</ul>`;

    return templateErrors;
}