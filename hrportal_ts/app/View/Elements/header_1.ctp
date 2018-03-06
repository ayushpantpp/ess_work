<header id="header_main">
    <div class="header_main_content">
        <nav class="uk-navbar">   
             <div class="uk-navbar-flip">
                <ul class="uk-navbar-nav user_actions">
                     <li class="md-color-grey-50 uk-text-bold margin-top"><?php echo "Welcome To, Eastern Software Systems"; ?></li></br>
                     <li class="md-color-grey-50 uk-text-bold margin-bottom"> 
                                <?php echo ucfirst(strtolower($this->Common->findDesignationName($auth['MyProfile']['desg_code'], $auth['User']['comp_code']))); ?>
                     </li> 
                </ul>
            </div>
        </nav>
    </div>
    <div class="header_main_search_form">
        <i class="md-icon header_main_search_close material-icons">ï¿½?</i>
        <form class="uk-form">
            <input type="text" class="header_main_search_input">
            <button class="header_main_search_btn uk-button-link"><i class="md-icon material-icons">î¢¶</i></button>
        </form>
    </div>
</header>