       // Include jsPDF library via CDN in your HTML before using this script.
// <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

document.getElementById("downloadPDF").addEventListener("click", function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Retrieve values from localStorage
    let applicationnumber = localStorage.getItem("currentAppNumber") || "Not Provided";
    let candidate = localStorage.getItem("candidate") || "Not Provided";
    let father = localStorage.getItem("father") || "Not Provided";
    let hname = localStorage.getItem("hname") || "Not Provided";
    let num = localStorage.getItem("num") || "Not Provided";
    let address = localStorage.getItem("address") || "Not Provided";
    let madrasa = localStorage.getItem("re") || "Not Provided";
    let addnum = localStorage.getItem("addnum") || "Not Provided";
    let declaration = localStorage.getItem("declaration") || "Not Provided";

    // Add text to the PDF
    doc.setFont("helvetica", "normal");
    doc.setFontSize(16);
    doc.text("Application Number: " + applicationnumber, 10, 20);
    doc.text("Candidate Name: " + candidate, 10, 30);
    doc.text("Father/Guardian Name: " + father, 10, 40);
    doc.text("House Name: " + hname, 10, 50);
    doc.text("Phone Number: " + num, 10, 60);
    doc.text("Address: " + address, 10, 70);
    doc.text("Madrasa Name: " + madrasa, 10, 80);
    doc.text("Admission Number: " + addnum, 10, 90);
    doc.text("Declaration: " + declaration, 10, 100);

    // Add images from local storage or fallback image
    let imageData = localStorage.getItem("imageData"); // Assuming Base64 encoded image is stored
    if (imageData) {
        doc.addImage(imageData, "JPEG", 10, 110, 100, 80); // Adjust position & size
    } else {
        doc.addImage("p1.jpg", "JPEG", 10, 110, 100, 80); // Default image
    }

    // Generate and download the PDF
    doc.save("Candidate_Details.pdf");
});