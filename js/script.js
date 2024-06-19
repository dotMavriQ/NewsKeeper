(() => {
    const categoryFilter = document.getElementById('category-filter');
    const tagFilter = document.getElementById('tag-filter');

    function fetchFilteredPosts() {
        const categoryId = categoryFilter.value.split('-')[1]; // Assuming values like "cat-1"
        const tagId = tagFilter.value.split('-')[1]; // Assuming values like "tag-1"

        // AJAX request to WordPress
        jQuery.ajax({
            url: wpApiSettings.root + 'newskeeper/v1/filter_posts',
            method: 'POST',
            data: {
                'category_id': categoryId,
                'tag_id': tagId
            },
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
            },
            success: function(data) {
                // Update the posts container with new posts
                document.getElementById('newskeeper-posts').innerHTML = data;
            }
        });
    }

    categoryFilter.addEventListener('change', fetchFilteredPosts);
    tagFilter.addEventListener('change', fetchFilteredPosts);

    console.log("hello")
})();
