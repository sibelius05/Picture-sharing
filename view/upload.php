<?php ?>
<main>
    <?php
    $isUser = false;

    if (isset($_SESSION['userId']))
    {
        $user = User::getById($_SESSION['userId']);

        $isUser = $user->isUser();
    }

    if (isset($user) && $isUser)
    {
    ?>
    <section class="py-0 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light"><?php echo $n->getHeadline() ?></h1>
                <p class="lead text-muted"><a href="/<?php echo $user->getUsername() ?>">zurück</a></p>
            </div>
        </div>
    </section>
    <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="bd-example-snippet bd-code-snippet">
                <div class="bd-example">
                    <form id="uploadform" method="post" enctype="multipart/form-data">
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="files" name="files">
                            <label class="input-group-text" for="files">Hochladen</label><br/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalXl" tabindex="-1" aria-labelledby="exampleModalXlLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="">
                    <div id="result" style="min-height: 100%">
                        <div style="height: 2000px;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col">
                            <div class="modal-body p-5 pt-0">
                                <form id="uploadData" action="" method="POST">
                                    <input type="hidden" name="action" value="fileUpload">
                                    <input type="hidden" id="userId" name="userId" value="<?php echo $user->getId(); ?>">
                                    <input type="hidden" id="sliderOneValue" name="sliderOneValue" value="0">
                                    <input type="hidden" id="sliderTwoValue" name="sliderTwoValue" value="0">
                                    <input type="hidden" id="sliderThreeValue" name="sliderThreeValue" value="0">
                                    <input type="hidden" id="sliderFourValue" name="sliderTwoValue" value="0">
                                    <input type="hidden" id="fileToUpload" name="fileToUpload" value="">
                                    <input type="hidden" id="fileRatio" name="fileRatio" value="">
                                    <div class="form-floating mb-3">
                                        <input type="text" id="fileDescription" name="fileDescription" value="">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col">
                            <div class="values">
                                <span id="range1">0</span>
                                <span> &dash; </span>
                                <span id="range2">0</span>
                            </div>
                            <div class="slider-track"></div>
                            <div style="position:relative;">
                                <input type="range" class="form-range" min="0" max="0" value="0" id="slider-1">
                                <input type="range" class="form-range" min="0" max="0" value="0" id="slider-2">
                            </div>
                            <div class="values">
                                <span id="range3">0</span>
                                <span> &dash; </span>
                                <span id="range4">0</span>
                            </div>
                            <div style="position:relative;">
                                <input type="range" class="form-range" min="0" max="0" value="0" id="slider-3">
                                <input type="range" class="form-range" min="0" max="0" value="0" id="slider-4">
                            </div>
                        </div>
                        <div class="col">
                            <div class="bd-example">
                                <button id="button" class="w-100 mb-2 btn btn-lg rounded-3 btn-primary">
                                    Hochladen
                                </button>
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/js/upload.js"></script>
        <style src="/js/upload.js"></style>
        <?php
        }
        else if (empty($user))
        {
            echo "Sitzung beendet!";
        } ?>
</main>
