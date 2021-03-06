<?php

  if (isset($_GET['id']) && !ctype_digit($_GET['id']) || $_GET['id'] < 10000){
    header('HTTP/1.0 404 Not Found', TRUE, 403);
    die(header('Location: ./'));
  }

?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="parkjongwon.com" />
    <title>The Scroll - DA Student Newspaper</title>
    <!-- <link rel="canonical" href="https://thescroll.com/" /> -->
    <link rel="stylesheet" href="./lib/style/dist/normalize.min.css" />
    <link rel="stylesheet" href="./lib/style/dist/universal.min.css<?php echo "?v=".filemtime("./lib/style/dist/universal.min.css"); ?>" />
    <link rel="stylesheet" href="./lib/style/dist/article.min.css<?php echo "?v=".filemtime("./lib/style/dist/article.min.css"); ?>" />
    <link rel="stylesheet" href="./lib/style/dist/article-format.min.css<?php echo "?v=".filemtime("./lib/style/dist/article-format.min.css"); ?>" />
    <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:600,600i|Spectral:400,400i,700,700i|Libre+Baskerville:400,400i&display=swap" rel="stylesheet">
    <!-- Gentium+Basic:400 -->
    <noscript>
      You need to enable JavaScript to run this app.
    </noscript>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-146912859-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-146912859-2');
    </script>
  </head>

  <body>

    <div id="layout">
      <div id="header" class="layout-container layout-header">
        <div id="site-nav" class="header-parent">
          <div id="header-mini" class="header-row header-mini amplified">
            <div class="header-container header-container-mini">
              <div class="header-wrapper header-wrapper-top">
                <div class="header-top-col mini header-top-items header-top-col-left">
                  <div class="header-top-item mini header-top-menu-trigger">
                    <span class="one"></span>
                    <span class="two"></span>
                    <span class="three"></span>
                  </div>
                  <div class="header-top-item mini header-top-search-trigger">
                    <img src="./lib/svg/icon-search.svg" title="Search" />
                  </div>
                </div>
                <div class="header-top-col mini header-top-col-center">
                  <a class="header-top-logo mini" href="./" title="Go to Deerfield Scroll homepage"></a>
                </div>
                <div class="header-top-col mini header-top-col-right">
                  <div class="header-mini-actions">
                    <div class="header-mini-action-btn header-mini-action-subscribe"><a>Subscribe</a></div>
                    <!-- <div class="header-mini-action-btn"><a href="./login.php">Login</a></div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="header-nav" class="header-row header-nav standalone">
            <div class="header-nav-container">
              <div class="header-nav-list">
                <div class="header-nav-item"><a href="./">Home</a></div>
                <div class="header-nav-item"><a href="./section.php?id=12">News</a></div>
                <div class="header-nav-item"><a href="./section.php?id=9">Features</a></div>
                <div class="header-nav-item"><a href="./section.php?id=13">Opinion</a></div>
                <div class="header-nav-item"><a href="./section.php?id=7">Editorial</a></div>
                <div class="header-nav-item"><a href="./section.php?id=2">Arts</a></div>
                <div class="header-nav-item"><a href="./section.php?id=14">Sports</a></div>
                <div class="header-nav-item"><a href="./section.php?id=3">Buzz</a></div>
              </div>
              <!-- <div class="header-nav-vd"></div> -->
              <div class="header-nav-list">
                <div class="header-nav-item"><a href="./section.php">Archives</a></div>
                <div class="header-nav-item"><a href="./section.php">About</a></div>
              </div>
              <div class="header-nav-list">
                <div class="header-nav-item"><a href="./section.php">Vol. XCVII</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="content" class="layout-container layout-content layout-article">
        <div id="article-viewer" class="arf arf-fluid">
          <div class="arf-container">
            <div id="article-header" class="arv-header arf-header">
              <div class="arf-block">
                <div id="article-title" class="arf-hd-title ar-loading ar-ld-title"></div>
                <div id="article-summary" class="arf-hd-summary ar-loading ar-ld-summary"></div>
              </div>
              <div id="article-hd-cover" class="arf-hd-cover">
                <div id="article-cover-image" class="arf-hd-cover-image ar-loading ar-ld-cover-image"></div>
                <div class="arf-hd-cover-caption ar-loading ar-ld-cover-caption"></div>
              </div>
            </div>
            <div class="arv-body arf-body">
              <div id="article-meta" class="arf-meta arf-mt">
                <div id="article-meta-one" class="arf-mt-row ar-loading ar-ld-meta-row">
                  <div id="article-author" class="arf-mt-item arf-mt-author"></div>
                  <div class="arf-mt-item arf-mt-published"><span id="article-published"></span></div>
                </div>
                <!-- <div class="arf-mt-row">
                </div> -->
              </div>
              <div id="article-content" class="arf-content arf-ct">
                <div class="ar-loading ar-ld-content"></div>
              </div>
            </div>
            <div id="article-related-wrapper" class="arv-more arf-short">
              <div class="arv-mr-header arv-mr-hd">
                <div class="arv-mr-hd-title ar-loading ar-ld-summary"></div>
              </div>
              <div id="article-related" class="arv-mr-content arv-mr-ct ar-loading ar-ld-cover-image">
                <!-- <div class="arv-mr-article">
                  <div class="arv-mr-ar-img" style=""></div>
                  <div class="arv-mr-ar-section"></div>
                  <div class="arv-mr-ar-headline"></div>
                  <div class="arv-mr-ar-published"></div>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="footer" class="layout-container layout-home">

      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
    const articleId = <?php echo $_GET['id'];?>;
    </script>
    <script src="./lib/script/dist/article.bundle.js<?php echo "?v=".filemtime("./lib/script/dist/article.bundle.js"); ?>"></script>
	</body>
</html>
