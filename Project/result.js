document.addEventListener('DOMContentLoaded', function() {
    const resultsTableBody = document.getElementById('resultsTable').getElementsByTagName('tbody')[0];
    const results = JSON.parse(sessionStorage.getItem('comparisonResults'));

    // Retrieve group names and update table headers
    document.getElementById('headerGroup1').textContent = sessionStorage.getItem('groupName1');
    document.getElementById('headerGroup2').textContent = sessionStorage.getItem('groupName2');

    if (results && results.length > 0) {
        results.forEach(result => {
            const newRow = resultsTableBody.insertRow();
            
            // File 1 name (without .docx)
            newRow.insertCell(0).innerHTML = <a href="${result.file1.url}" download="${result.file1.name}">${result.file1.name}</a>;
            
            // File 2 name (without .docx)
            newRow.insertCell(1).innerHTML = <a href="${result.file2.url}" download="${result.file2.name}">${result.file2.name}</a>;
            
            // Generate the "Reason" text based on similarity percentage
            const reason = 'These two files are very similar to one another as the similarity % is: ${result.file2.similarity}%. It means these are applicable for cross crediting.';
            newRow.insertCell(2).textContent = reason;
        });
    } else {
        const newRow = resultsTableBody.insertRow();
        const noResultCell = newRow.insertCell(0);
        noResultCell.colSpan = 3;
        noResultCell.textContent = "No results to display.";
    }
});

// Function to go back to the previous page
function goBack() {
    window.history.back();
}