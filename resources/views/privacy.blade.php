<html lang="en">
@include('components.head')
<body>
<div class="homeFooter" role="main">
    <div class="container justify-content-center">
        <div class="index pt-3">
            <h1 class="text-card pb-1 pt-1" role="heading" aria-level="1">Privacy policy</h1>
            <p class="lead text-card pb-3">Spotify stats is a simple web app used to view statistics about your Spotify account. This site is free to use and you can find our policies regarding the collection and usage of information obtained from users below.</p>
            <h2 class="text-card pb-1 pt-1" role="heading" aria-level="1">Information collection and usage</h1>
            <p class="lead text-card pb-3">For a better experience while using this service we may require you to provide us with some personally identifiable information. This information is limited to your Spotify username, a Spotify web API access token/refresh token and some information regarding your top artists/tracks. All of this information is obtained using the Spotify web API. This information is not shared with anyone else or used for any other purpose other than to display your top statistics to you on this site.</p>
            <h2 class="text-card pb-1 pt-1" role="heading" aria-level="1">Cookies</h1>
            <p class="lead text-card pb-3">Spotify stats uses the Laravel framework and as such sets a cookie that maintains a users login state.</p>
        </div>
    </div>
</div>
</body>
@include('components.footer')
</html>