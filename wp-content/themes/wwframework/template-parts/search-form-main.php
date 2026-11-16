<form role="search" method="get" id="search-form-main" class="search-form search-form-main" action="/">
    <label class="sr-text" for="s">Search for:</label>
    <div class="input-wrap">
        <input type="text" class="st-default-search-input" value="<?php echo $_GET['s']; ?>" name="s" id="s" placeholder="Search for..." aria-labelledby="Search for...">
        <div class="submit-wrap">
            <div class="flex-wrap">
                <input type="submit" id="searchsubmit" value="Search">
                <div class="icon-search"></div>
            </div>
        </div>
    </div>
</form>