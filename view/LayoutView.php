<?php


class LayoutView {
  public function render($view, $isLoggedIn) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>RUCK PUPER SCUSSORS</title>
        </head>
        <body>
          <h1>ROCK PAPER SCISSORS!</h1>     
          <div class="container">
              ' . $this->generateRegisterLinkHTML($isLoggedIn) . '
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
      return '<a href=?game>Play Casual</a>';
  }
   private function generateRegisterLinkHTML($isLoggedIn) {
    if(!$isLoggedIn)
    {
      if(isset($_GET['register']))
      {
        return '<a href=?>Back to login</a>';
      }
      else
      return '<a href=?register>Register a new user</a>';
    }
  }
}
