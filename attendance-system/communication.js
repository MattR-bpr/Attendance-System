const output = document.getElementById("output");


const chip = document.getElementById("chip");
chip.addEventListener("click", async () => {

    const fullName = document.getElementById("chip-full-name").value;
    const chipType = document.getElementById("chip-type").value;

    const data = new FormData();
    data.append("full-name", fullName);
    data.append("chip-type", chipType);

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

    const fullName = document.getElementById("view-full-name").value;
    const date = document.getElementById("view-date").value;

    const data = new FormData();
    data.append("full-name", fullName);
    data.append("date", date);

    const response = await fetch("/attendance-system/api/view.php", {
        method: "POST",
        body: data
    });

    output.innerHTML = await response.text();

});