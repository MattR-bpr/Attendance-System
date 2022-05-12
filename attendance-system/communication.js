const output = document.getElementById("output");


const chip = document.getElementById("chip");
chip.addEventListener("click", async () => {

    const employee = document.getElementById("chip-employee").value;
    const chipType = document.getElementById("chip-type").value;

    const data = new FormData();
    data.append("employee", employee);
    data.append("chip-type", chipType);

    const response = await fetch("/attendance-system/api/chip.php", {
        method: "POST",
        body: data
    });
    
    output.innerHTML = await response.text();

});


const chipRecords = document.getElementById("chip-records");
chipRecords.addEventListener("click", async () => {

    const employee = document.getElementById("chip-records-employee").value;
    const date = document.getElementById("chip-records-date").value;

    const data = new FormData();
    data.append("employee", employee);
    data.append("date", date);

    const response = await fetch("/attendance-system/api/chip-records.php", {
        method: "POST",
        body: data
    });

    output.innerHTML = await response.text();

});


const operation = document.getElementById("operation");
operation.addEventListener("click", async () => {

    const employee = document.getElementById("operation-employee").value;
    const operationType = document.getElementById("operation-type").value;

    const data = new FormData();
    data.append("employee", employee);
    data.append("operation-type", operationType);

    const response = await fetch("/attendance-system/api/operation.php", {
        method: "POST",
        body: data
    });

    output.innerHTML = await response.text();

});


const operationRecords = document.getElementById("operation-records");
operationRecords.addEventListener("click", async () => {

    const employee = document.getElementById("operation-records-employee").value;
    const date = document.getElementById("operation-records-date").value;

    const data = new FormData();
    data.append("employee", employee);
    data.append("date", date);

    const response = await fetch("/attendance-system/api/operation-records.php", {
        method: "POST",
        body: data
    });

    output.innerHTML = await response.text();

});


const reporting = document.getElementById("reporting");
reporting.addEventListener("click", async () => {

    const employee = document.getElementById("reporting-employee").value;
    const date = document.getElementById("reporting-date").value;

    const data = new FormData();
    data.append("employee", employee);
    data.append("date", date);

    const response = await fetch("/attendance-system/api/reporting.php", {
        method: "POST",
        body: data
    });

    output.innerHTML = await response.text();

});