<main>
        <!-- Section -->
        <section class="vh-lg-100 d-flex align-items-center" style="background-color: #f5f8fb;">
            <div class="container">
                <div class="row justify-content-center form-bg-image" data-background-lg="/admin/template/assets/img/illustrations/signin.svg">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="signin-inner my-3 my-lg-0 bg-white shadow-soft border rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                            <div class="text-center text-md-center mb-4 mt-md-0">
                                <h1 class="mb-0 h3">NOVODOM<span style="color: #f16821;">.online</span></h1>
                            </div>
                            <form action="" method="post" id="form_signIn" class="mt-4">
                                <!-- Form -->
                                <div class="form-group mb-4">
                                    <label for="login">Ваш логин</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><span class="fas fa-user"></span></span>
                                        <input type="text" class="form-control" placeholder="" id="login" name="login@" autocomplete="off" value="" autofocus required>
                                    </div>  
                                </div>
                                <!-- End of Form -->
                                <div class="form-group">
                                    <!-- Form -->
                                    <div class="form-group mb-4">
                                        <label for="password">Ваш пароль</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon2"><span class="fas fa-unlock-alt"></span></span>
                                            <input type="password" placeholder="***************" class="form-control" id="password" name="pass@" value="" required>
                                        </div>  
                                    </div>
                                    <!-- End of Form -->
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" value="1" id="defaultCheck5">
                                            <label class="form-check-label" for="defaultCheck5">
                                              Запомнить меня
                                            </label>
                                        </div>
                                        <div><a href="#" class="small text-right">Звбыли пароль?</a></div>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="module" value="login" />
                                <input type="hidden" name="component" value="" />
                                <input type="hidden" name="url" value="<?=$_SERVER['REQUEST_URI'];?>" />
                                
                                <button type="submit" id="signIn" class="send_form btn btn-block btn-primary">Войти</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>