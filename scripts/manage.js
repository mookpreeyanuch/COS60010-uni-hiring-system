/**
* Author: TripleP
* Target: manage.php
* Purpose: Use for manage.php
* Last updated: 19 May 2023
* Credits:
*/

window.onload = function () {
    const deleteForm = document.querySelector(`form#delete-form`);
    if (deleteForm) {
        deleteForm.addEventListener("submit", event => {
            if (! confirm('Do you want to delete?')) {
                event.preventDefault();
                return false;
            }

            return true;
        });
    }

    const changeFormSelectList = document.querySelectorAll(`form[id^="change-form-"] select[name="status"]`);
    for (var i = 0; i < changeFormSelectList.length; i++) {
        let id = changeFormSelectList[i].dataset.id;

        changeFormSelectList[i].addEventListener("change", function(event) {
            let newStatus = event.target.value;
            if (newStatus != "") {
                document.getElementById("change-form-" + id).submit();
            }
        });
    }
};