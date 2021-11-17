let
    selectedRadio,
    selectedCheckbox,
    submitButton = document.getElementById("submit_button");

function checkY(inputY) {
    let y = inputY.value.trim().replace(",", ".")
    if (y === "") {
        inputY.setCustomValidity("Введите значение")
        return false
    } else if (!isFinite(+y)) {
        inputY.setCustomValidity("Значение должно быть конечным")
        return false
    } else if (+y <= -3 || +y >= 5) {
        inputY.setCustomValidity("Значение должно входить в диапазон (-3 ... 5)")
        return false
    }
    updateSubmitButton(true)
    return true
}
function changeX(element){
    selectedRadio = element
    updateSubmitButton();
}

function changeR(element) {
    if (element.checked) {
        if (selectedCheckbox !== undefined) {
            selectedCheckbox.checked = false
        }
        selectedCheckbox = element
    }
    else {
        selectedCheckbox = undefined
    }
    updateSubmitButton();
}

function updateSubmitButton(yIsCheckedAndCorrect = false) {
    if (submitButton === undefined) {
        submitButton = document.getElementById("submit_button");
    } else {
        // check x, y, z
        submitButton.disabled = !(selectedRadio !== undefined
            && selectedCheckbox !== undefined
            && (yIsCheckedAndCorrect || checkY(document.getElementById('Y')))
        );
    }
}

document.getElementById("values_selection").addEventListener("submit", e => {
    e.preventDefault(); // prevent submitting
    let formData = new FormData(),
        xValue = selectedRadio.value,
        yValue = document.getElementById("Y").value.replace(',', '.'),
        rValue = selectedCheckbox.value;
    formData.append("x", xValue);
    formData.append("y", yValue);
    formData.append("r", rValue);
    console.log(`x = ${xValue}, y = ${yValue}, r = ${rValue}`);
    let xhr = new XMLHttpRequest();
    xhr.onloadend = () => {
        if (xhr.status === 200) {
            document.getElementById("results_table").innerHTML = xhr.response;
        } else console.log("status: ", xhr.status)
    };
    xhr.open("POST", "server/server.php");
    xhr.send(formData);
})

document.getElementById("clear_button").addEventListener("click", e => {
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.onloadend = () => {
        if (xhr.status === 200) {
            document.getElementById("results_table").innerHTML = xhr.response;
        } else console.log("status: ", xhr.status)
    };
    xhr.open("POST", "server/clear.php");
    xhr.send();
})

window.onload = function () {
    let xhr = new XMLHttpRequest();
    xhr.onloadend = () => {
        if (xhr.status === 200) {
            document.getElementById("results_table").innerHTML = xhr.response;
        } else console.log("status: ", xhr.status)
    };
    xhr.open("GET", "server/onload.php");
    xhr.send();
}
