document.addEventListener('DOMContentLoaded', function() {
    var candidateSelects = document.querySelectorAll('select[name^="candidateSelect"]');
    
    // Function to disable options in subsequent selects
    function disableOptions(select, index) {
        var selectedOption = select.value;
        for (var i = index + 1; i < candidateSelects.length; i++) {
            var options = candidateSelects[i].options;
            for (var j = 0; j < options.length; j++) {
                if (options[j].value === selectedOption) {
                    options[j].disabled = true;
                }
            }
        }
    }

    candidateSelects.forEach(function(select, index) {
        select.addEventListener('change', function() {
            disableOptions(this, index);
        });

        // Disable options if already selected
        if (select.value) {
            disableOptions(select, index);
        }
    });
});
function displayPostInfo() {
    var select = document.getElementById("postSelect");
    var selectedValue = select.value;
    var infoDisplay = document.getElementById("postInfoDisplay");

    // Clear previous content
    infoDisplay.innerHTML = "";

    // Check if a post is selected
    if (selectedValue !== "") {
        //display the selected post
        var infoText = "You selected: " + selectedValue;
        infoDisplay.textContent = infoText;
    }
}
