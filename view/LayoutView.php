<?php


class LayoutView {
  public function render($view) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>ROCK PAPER SCISSORS!</h1>     
          <div class="container">
              ' . $this->generatePlayLink() . '
              ' . $view->response() . '    
          </div>
         </body>
      </html>
    ';
  }

  private function generatePlayLink() {
      if(isset($_GET['game']))
      {
        return '<a href=?>Back to start</a>';
      }
      else
      return '<a href=?game>Play game</a>';
  }
}
