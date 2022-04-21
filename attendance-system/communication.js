const output = document.getElementById("output");


const chip = document.getElementById("chip");
chip.addEventListener("click", async () => {

    const employeeId = document.getElementById("chip-employee-id").value;
    const chipTypeId = document.getElementById("chip-type-id").value;

    const data = new FormData();
    data.append("employee-id", employeeId);
    data.append("chip-type-id", chipTypeId);

    const response = await fetch("/attendance-system/api/chip.php", {
        method: "POST",
        body: data
    });
    
    output.innerHTML = await response.text();
    setTimeout(() => {
        output.innerHTML = "";
    }, 2000);

});


const view = document.getElementById("view");
view.addEventListener("click", async () => {

    const employeeId = document.getElementById("view-employee-id").value;
    const date = document.getElementById("view-date").value;

    const data = new FormData();
    data.append("employee-id", employeeId);
    data.append("date", date);

    const response = await fetch("/attendance-system/api/view.php", {
        method: "POST",
        body: data
    });

    output.innerHTML = await response.text();

});


const operation = document.getElementById("operation");
operation.addEventListener("click", async () => {

    const employeeId = document.getElementById("operation-employee-id").value;
    const operationTypeId = document.getElementById("operation-type-id").value;

    const data = new FormData();
    data.append("employee-id", employeeId);
    data.append("operation-type-id", operationTypeId);

    const response = await fetch("/attendance-system/api/operation.php", {
        method: "POST",
        body: data
    });

    output.innerHTML = await response.text();
    setTimeout(() => {
        output.innerHTML = "";
    }, 2000);

});