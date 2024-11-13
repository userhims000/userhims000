<div class="taggbox_content_wrapper___">
    <div class="taggbox_info_wrapper">
        <div class="taggbox_info_in___">
            <?php _e('<div class="tg_login_head_001">Welcome to Taggbox Widget</div>', 'textdomain'); ?>
            <?php _e('<div class="tg_login_des00">Embed in your WordPress site and Showcase the power of your hashtag. Build trust and engagement with your audience. Drive more social purchase and increase revenues too</div>', 'textdomain'); ?>
        </div>
    </div>
    <div class="taggbox-login-container">
        <div class="taggbox_custom-row">
            <div class="tb_form_area">
                <div class="taggbox__form__">
                    <div class="taggbox-logoLogin">
                        <a href="https://taggbox.com/widget/" target="_blank">
                            <img src="<?= TAGGBOX_PLUGIN_URL . '/assets/images/taggbox-widget.svg' ?>" width="260" height="42" alt="Taggbox Widget">
                        </a>
                    </div>
                    <div class="taggbox-loginWithSocials">
                        <div class="taggbox-loginHead">
                            <div class="tgg_login_heading">Login to Taggbox</div>
                        </div>
                        <div class="taggbox-loginSocials">
                            <div class="tgg_sign_in__">Sign in with:</div>
                            <div class="taggbox-social-network taggbox-social-circle">
                                <a href="https://app.taggbox.com/plugin/api/google_login?wpredirecturl=<?= TAGGBOX_PLUGIN_SOCIAL_LOGIN_CALL_BACK_URL; ?>" class="icoGoogle" title="Google +"> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 256 262" preserveAspectRatio="xMidYMid"><path d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027" fill="#4285F4"></path><path d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1" fill="#34A853"></path><path d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782" fill="#FBBC05"></path><path d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251" fill="#EB4335"></path></svg>
                                <div>Google</div>
                                </a>

                                <a href="https://app.taggbox.com/plugin/fb_login?wpredirecturl=<?= TAGGBOX_PLUGIN_SOCIAL_LOGIN_CALL_BACK_URL; ?>" class="icoFacebook" title="Facebook"> 
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="23" height="23" id="Capa_1" x="0px" y="0px" viewBox="0 0 167.657 167.657" style="enable-background:new 0 0 167.657 167.657;" xml:space="preserve">
                                <path style="fill:#1777F2" d="M83.829,0.349C37.532,0.349,0,37.881,0,84.178c0,41.523,30.222,75.911,69.848,82.57v-65.081H49.626   v-23.42h20.222V60.978c0-20.037,12.238-30.956,30.115-30.956c8.562,0,15.92,0.638,18.056,0.919v20.944l-12.399,0.006   c-9.72,0-11.594,4.618-11.594,11.397v14.947h23.193l-3.025,23.42H94.026v65.653c41.476-5.048,73.631-40.312,73.631-83.154   C167.657,37.881,130.125,0.349,83.829,0.349z"></path>
                                </svg>
                                <div>Facebook</div>         
                                </a>
                                
                                <a href="https://app.taggbox.com/plugin/api/twitter_login?wpredirecturl=<?= TAGGBOX_PLUGIN_SOCIAL_LOGIN_CALL_BACK_URL; ?>" class="icoTwitter" title="Twitter"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="23" height="23" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                    <path style="fill:#03A9F4;" d="M512,97.248c-19.04,8.352-39.328,13.888-60.48,16.576c21.76-12.992,38.368-33.408,46.176-58.016  c-20.288,12.096-42.688,20.64-66.56,25.408C411.872,60.704,384.416,48,354.464,48c-58.112,0-104.896,47.168-104.896,104.992  c0,8.32,0.704,16.32,2.432,23.936c-87.264-4.256-164.48-46.08-216.352-109.792c-9.056,15.712-14.368,33.696-14.368,53.056  c0,36.352,18.72,68.576,46.624,87.232c-16.864-0.32-33.408-5.216-47.424-12.928c0,0.32,0,0.736,0,1.152  c0,51.008,36.384,93.376,84.096,103.136c-8.544,2.336-17.856,3.456-27.52,3.456c-6.72,0-13.504-0.384-19.872-1.792  c13.6,41.568,52.192,72.128,98.08,73.12c-35.712,27.936-81.056,44.768-130.144,44.768c-8.608,0-16.864-0.384-25.12-1.44  C46.496,446.88,101.6,464,161.024,464c193.152,0,298.752-160,298.752-298.688c0-4.64-0.16-9.12-0.384-13.568  C480.224,136.96,497.728,118.496,512,97.248z"></path>
                                    </svg>
                                    <div>Twitter</div>
                                </a>
                            </div>
                            <div class="tgg_or_txt00"><div>or</div></div>
                        </div>
                    </div>
                    <div class="taggbox-account-widget">
                        <div class="tb_error_msg00">
                        </div>
                        <?php
                            if (isset($_GET['error'])) {
                                if ($_GET['error'] == "social-login-error") {
                                    ?>
                                    <div class="tb_alert__ tb_alert__danger"><div class="tb_alert__text">You don't have any account. please create account first.</div></div>
                                    <?php
                                }
                            }
                        ?>
                        <form action="javascript:void(0)" id="formTaggboxLogin" class="taggbox-form-signin">
                            <div class="tb_form_group">
                                <label class="tb_form_label" for="email">Email<div>*</div></label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="tb_form_control"
                                       required
                                       autofocus />
                            </div>
                            <div class="tb_form_group">
                                <label class="tb_form_label" for="password">Password<div>*</div></label>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="tb_form_control"
                                       required />
                            </div>
                            <div class="tb_form_group">
                                <button id="tb_submit_login_btn" class="tb_btn submit_btn" type="submit">Login</button>
                            </div>
                            <div class="tb_form_group">
                                <div class="tgg_signup_00">Don't have an account? <a class="btnSignUp" target="_blank" href="https://app.taggbox.com/widget/accounts/register">Sign Up</a></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tb_content_area taggbox_form_side____">
                <div class="taggbox__side_img" <?php echo 'style="background-image: url(' . TAGGBOX_PLUGIN_URL . '/assets/images/taggbox_wall_bg-min.png' . ')"' ?>></div>
            </div>
        </div>
    </div>
</div>