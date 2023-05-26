/**
* Author: TripleP
* Target: apply.php
* Purpose: Validate
* Last updated: 19 May 2023
* Credits:
*/
const stateArray = {
    "VIC": [3, 8],
    "NSW": [1, 2],
    "QLD": [4, 9],
    "NT": [0],
    "WA": [6],
    "SA": [5],
    "TAS": [7],
    "ACT": [0],
};

const skillArray = {
    "skill1": "Doctoral degree",
    "skill2": "Masters degree",
    "skill3": "Graduate diploma",
    "skill4": "Graduate certificate",
    "skill5": "Bachelor degree",
    "skill6": "other",
};

const availabilityArray = {
    "mon1": "Monday-Morning",
    "mon2": "Monday-Afternoon",
    "mon3": "Monday-Evening",
    "tue1": "Tueday-Morning",
    "tue2": "Tueday-Afternoon",
    "tue3": "Tueday-Evening",
    "wed1": "Wednesday-Morning",
    "wed2": "Wednesday-Afternoon",
    "wed3": "Wednesday-Evening",
    "thu1": "Thursday-Morning",
    "thu2": "Thursday-Afternoon",
    "thu3": "Thursday-Evening",
    "fri1": "Friday-Morning",
    "fri2": "Friday-Afternoon",
    "fri3": "Friday-Evening",
};

function calculateAge(dob) {
    var diffMs = Date.now() - dob.getTime();
    var ageDiff = new Date(diffMs); 
  
    return Math.abs(ageDiff.getUTCFullYear() - 1970);
}

function validate() {
    var dateOfBirth = document.getElementById("date_of_birth");
    var state = document.getElementById("state");
    var postcode = document.getElementById("postcode");
    var skillOther = document.getElementById("skill-other");
    var otherSkills = document.getElementById("other_skills");

    var dateOfBirthError = document.getElementById("date_of_birth_error");
    var postcodeError = document.getElementById("postcode_error");
    var otherSkillsError = document.getElementById("skill-other-box_error");

    var dateOfBirthValue = dateOfBirth.value;
    var stateValue = state.value;
    var postcodeValue = postcode.value;
    var otherSkillsValue = otherSkills.value;

    // Reset class is-invalid
    dateOfBirth.classList.remove("is-invalid");
    postcode.classList.remove("is-invalid");
    otherSkills.classList.remove("is-invalid");

    dateOfBirthError.classList.add("d-none");
    postcodeError.classList.add("d-none");
    otherSkillsError.classList.add("d-none");

    // console.log(dateOfBirth);
    // console.log(dateOfBirthValue, dateOfBirthValue.length);
    // console.log(postcode);
    // console.log(stateValue);
    // console.log(postcodeValue);
    // console.log(otherSkills);
    // console.log(otherSkillsValue);

    if (dateOfBirthValue && dateOfBirthValue.length == 10) {
        var newDateOfBirthValue = dateOfBirthValue.split("/").reverse().join("/");
        var newDate = new Date(newDateOfBirthValue);
        var age = calculateAge(newDate);
        // console.log(age);
        if (! (15 <= age && age <= 80)) {
            dateOfBirth.classList.add("is-invalid");
            dateOfBirthError.classList.remove("d-none");
            // alert("Applicants must be at between 15 and 80 years old.");
            return false;
        }
    }
    if (stateValue && postcodeValue && postcodeValue.length == 4) {
        var postcodeValueFirstChar = parseInt(postcodeValue.charAt(0));
        var stateFirstCharValue = stateArray[stateValue];
        // console.log(postcodeValueFirstChar);
        // console.log(stateFirstCharValue);
        // console.log(stateFirstCharValue.includes(postcodeValueFirstChar));
        if (! stateFirstCharValue.includes(postcodeValueFirstChar)) {
            postcode.classList.add("is-invalid");
            postcodeError.innerHTML = `The postcode ${postcodeValue} should match the state ${stateValue}.`;
            postcodeError.classList.remove("d-none");
            // alert(`The postcode ${postcodeValue} should match the state ${stateValue}.`);
            return false;
        }
    }
    if (skillOther.checked && otherSkillsValue === "") {
        otherSkills.classList.add("is-invalid");
        otherSkillsError.classList.remove("d-none");
        // alert("The Other Skills text area cannot be blank.");
        return false;
    }

    if (! skillOther.checked) {
        otherSkills.disabled = true;
    }

    return true;
}

function setJobRef() {
    var jobref = document.getElementById("jobref");

    // https://stackoverflow.com/questions/901115/how-can-i-get-query-string-values-in-javascript
    const querystring = new Proxy(new URLSearchParams(window.location.search), {
        get: (searchParams, prop) => searchParams.get(prop),
    });

    let jobrefValue = querystring.jobref;

    if (jobrefValue) {
        localStorage.setItem("jobref", jobrefValue);
        jobref.value = jobrefValue;
        jobref.readOnly = true;
    } else {
        let jobrefLocalValue = localStorage.getItem("jobref");
        if (jobrefLocalValue) {
            jobref.value = jobrefLocalValue;
            jobref.readOnly = true;
        }
    }
}

function bindInput(fieldId) {
    // https://developer.mozilla.org/en-US/docs/Web/API/Window/sessionStorage
    // Get the text field that we're going to track
    var field = document.getElementById(fieldId);

    // See if we have an autosave value
    // (this will only happen if the page is accidentally refreshed)
    if (sessionStorage.getItem(fieldId)) {
        // Restore the contents of the text field
        field.value = sessionStorage.getItem(fieldId);
    }

    // Listen for changes in the text field
    field.addEventListener("change", () => {
        // And save the results into the session storage object
        sessionStorage.setItem(fieldId, field.value);
    });
}

function bindRadio(fieldName) {
    // Get the text field that we're going to track
    var fieldList = document.querySelectorAll('input[name="' + fieldName + '"]');
    // console.log(fieldList);

    // See if we have an autosave value
    // (this will only happen if the page is accidentally refreshed)
    if (sessionStorage.getItem(fieldName)) {
        // Restore the contents of the text field
        let fieldValue = sessionStorage.getItem(fieldName);

        fieldList.forEach(radio => {
            if (radio.value == fieldValue) {
                radio.checked = true;
            }
        });
    }

    // Listen for changes in the text field
    fieldList.forEach(radio => {
        radio.addEventListener("change", () => {
            // And save the results into the session storage object
            sessionStorage.setItem(fieldName, radio.value);
        });
    });
}

function bindCheckbox(fieldName) {
    // Get the text field that we're going to track
    var fieldList = document.querySelectorAll('input[name="' + fieldName + '"]');
    // console.log(fieldList);

    // See if we have an autosave value
    // (this will only happen if the page is accidentally refreshed)
    if (sessionStorage.getItem(fieldName)) {
        // Restore the contents of the text field
        let fieldValue = sessionStorage.getItem(fieldName);

        fieldList.forEach(checkbox => {
            if (fieldValue.includes(checkbox.value)) {
                checkbox.checked = true;
            }
        });
    }

    // Listen for changes in the text field
    fieldList.forEach(checkbox => {
        checkbox.addEventListener("change", () => {
            // And save the results into the session storage object
            let skills = 
                Array.from(fieldList) // Convert checkboxes to an array to use filter and map.
                .filter(i => i.checked) // Use Array.filter to remove unchecked checkboxes.
                .map(i => i.value) // Use Array.map to extract only the checkbox values from the array of objects.
                
            sessionStorage.setItem(fieldName, skills);
        });
    });
}

window.onload = function () {
    setJobRef();

    var applyForm = document.querySelector(`form#apply-job`);
    if (applyForm) {
        applyForm.addEventListener("submit", event => {
            var validatePass = validate();
            if (! validatePass) {
                event.preventDefault();
                return false;
            }
            return true;
        });
    }

    bindInput("firstname");
    bindInput("lastname");
    bindInput("date_of_birth");
    bindRadio("gender");
    bindInput("street");
    bindInput("suburb");
    bindInput("state");
    bindInput("postcode");
    bindInput("email");
    bindInput("phone");
    bindCheckbox("skills[]");
    bindInput("other_skills");
    bindCheckbox("availability[]")
};