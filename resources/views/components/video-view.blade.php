<div class="video-container ">
    @foreach ($videos as $keys => $video)
        <div class="video-card">
            <div class="thumbnail-container">
                <img src="https://img.youtube.com/vi/{{$video->link}}/maxresdefault.jpg" alt="Video Thumbnail" class="thumbnail">
                <button style="width: 100%;border: none;background: red;color: white;"  onclick="openPopup('https://www.youtube.com/embed/{{$video->link}}')">Play</button>
            </div>
            <div class="video-info">
                <h3 class="video-title">{{$video->title}}</h3>
                <p class="video-description">{{$video->description}}</p>

                <!-- New Section: Creation Date -->
                <p class="video-date">Recorded on: <span>{{$video->recoded_at}}</span></p>
                <p class="video-date">Uploaded on: <span>{{ $video->created_at->diffForHumans() }}</span></p>

                <div style="display: flex;justify-content: space-around;">
                    <!-- Watch Now Button (opens in a popup) -->
                <a style=" padding: 10px 15px;" class="watch-btn" href="{{route('platform.systems.videos.update', $video->id)}}">Update</a>
                
                <!-- Open Classes Button -->
                <span style=" padding: 10px 15px;" class="open-classes-btn" onclick="toggleClassList('classList{{$keys}}')">Open Classes</span>

                {!!  Orchid\Screen\Actions\Button::make(__('Delete'))
                    ->style('background: #a70d0d;color: white;text-decoration: none;margin-left: 8px;height: 42px;')
                    ->confirm(__(' '))
                    ->method('remove', [
                        'id' => $video->id,
                    ])
                !!}
                </div>

                <ul class="class-list" id="classList{{$keys}}">
                    @foreach ($video->classHasVideos as $key => $class)
                        <li>{{ $key +1 .' - '. $class->class->name}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>


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