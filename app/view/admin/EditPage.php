<form action="api/page/saveHtml" method="post">
    <input type="hidden" name="id" value="<?=  $this->view['page']->id; ?>" />
    <textarea name="editor" id="editor" rows="80" cols="80">
              <?php
              $file = __DIR__ . ('/../pages/page-' . $this->view['page']->id . '.php');
              if (file_exists($file))
                  include $file;
              ?>
            </textarea>
</form>





