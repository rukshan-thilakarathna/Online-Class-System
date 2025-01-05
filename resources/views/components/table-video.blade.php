
<a href="https://www.youtube.com/embed/{{$VideoLink}}" target="_blank" rel="noopener noreferrer">
    <div class="thumbnail-container" style="width: 210px">
        <img src="https://img.youtube.com/vi/{{$VideoLink}}/maxresdefault.jpg" alt="Video Thumbnail" class="thumbnail">
    </div>
</a>


<script>
 
    // Function to toggle visibility of the class list
    function toggleClassList(x) {
        var classList = document.getElementById(x);
        if (classList.style.display === "none" || classList.style.display === "") {
            classList.style.display = "block";
        } else {
            classList.style.display = "none";
        }
    }

    // Function to open a popup window for the video
    function openPopup(videoUrl) {
        var width = 800;
        var height = 450;
        var left = (screen.width - width) / 2;
        var top = (screen.height - height) / 2;
        window.open(videoUrl, 'videoPopup', 'width=' + width + ',height=' + height + ',top=' + top + ',left=' + left + ',resizable=yes');
    }

</script>