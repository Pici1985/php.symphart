function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

docReady(function() {
    const articles = document.getElementById('articles');

    if(articles){
        articles.addEventListener('click', (e) => {
            if(e.target.className === 'btn btn-danger delete-article'){ 
                const id  = e.target.getAttribute('data-id');

                fetch(`/article/delete/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());         
            }       
        })
    }
});




 