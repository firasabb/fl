<template>
    <div>
        <div class="links-container">
            <div class="links-container-title text-center">
                <h4>LINKS</h4>
            </div>
            <div class="row links-container-row">
                <div class="col-6">
                    <div class="link-container">
                        <div class="form-row">
                            <div class="col">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Instagram</div>
                                    </div>
                                    <input class="form-control" name="instagram-link" placeholder="@username">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="link-container">
                        <div class="form-row">
                            <div class="col">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Facebook</div>
                                    </div>
                                    <input class="form-control" name="facebook-link" placeholder="@username">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="link-container">
                        <div class="form-row">
                            <div class="col">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Github</div>
                                    </div>
                                    <input class="form-control" name="github-link" placeholder="https://www.github.com/username">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="link-container">
                        <div class="form-row">
                            <div class="col">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">YouTube</div>
                                    </div>
                                    <input class="form-control" name="youtube-link" placeholder="https://www.youtube.com/channel">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="link-container">
                        <div class="form-row">
                            <div class="col">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Website</div>
                                    </div>
                                    <input class="form-control" name="website-link" placeholder="https://www.example.com">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="link-container">
                        <div class="form-row">
                            <div class="col">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Portfolio</div>
                                    </div>
                                    <input class="form-control" name="portfolio-link" placeholder="https://www.myportfolio.com">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data: function(){
            return{
                i: 2
            }
        },
    }
</script>