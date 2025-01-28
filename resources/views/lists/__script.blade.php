<script>
    let lastClickedTab = null; // Track the last clicked tab
    document.querySelectorAll('.nav-link').forEach(function(tab) {
        tab.classList.add('cursor-pointer'); // Add hand icon
        // Click behavior
        tab.addEventListener('click', function() {
            // Remove active class, background, and text color from all tabs
            document.querySelectorAll('.nav-link').forEach(function(tab) {
                tab.classList.remove('active', 'bg-label-primary', 'text-white');
            });

            // Add active class, background, and text color to the clicked tab
            this.classList.add('active', 'bg-label-primary', 'text-white');

            // Show the corresponding tab content
            const tabId = this.getAttribute('data-bs-target');
            document.querySelectorAll('.tab-pane').forEach(function(content) {
                content.classList.remove('show', 'active');
            });
            document.querySelector(tabId).classList.add('show', 'active');

            // Update the last clicked tab
            lastClickedTab = this;
        });

        // Hover behavior
        tab.addEventListener('mouseover', function() {
            // Add hover styles to the current tab
            document.querySelectorAll('.nav-link').forEach(function(tab) {
                tab.classList.remove('active', 'bg-label-primary', 'text-white');
            });

            const tabId = this.getAttribute('data-bs-target');
            document.querySelectorAll('.tab-pane').forEach(function(content) {
                content.classList.remove('show', 'active');
            });
            this.classList.add('bg-label-primary', 'text-white');
            document.querySelector(tabId).classList.add('show', 'active');
        });

        tab.addEventListener('mouseout', function() {
            // Remove hover styles from the current tab
            this.classList.remove('bg-label-primary', 'text-white');

            if (lastClickedTab) {
                // Revert to the last clicked tab's background and content
                lastClickedTab.classList.add('bg-label-primary', 'text-white');

                const tabId = lastClickedTab.getAttribute('data-bs-target');
                document.querySelectorAll('.tab-pane').forEach(function(content) {
                    content.classList.remove('show', 'active');
                });
                document.querySelector(tabId).classList.add('show', 'active');
            } else {
                // If no tab is clicked, hide all tab content
                document.querySelectorAll('.tab-pane').forEach(function(content) {
                    content.classList.remove('show', 'active');
                });
            }
        });
    });
</script>