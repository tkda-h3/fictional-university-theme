import $ from 'jquery';

class Search {
  // 1. init
  constructor() {
    this.addSearchHtml();

    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term");
    this.resultDiv = $('#search-overlay__results');
    this.events();
    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;
    this.previousValue;
    this.typingTimer;
  }

  // 2. events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    $(document).on("keydown", this.keyPressDispatcher.bind(this));
    this.searchField.on("keydown", this.typingLogic.bind(this));
  }

  // 3. method (function, action ...)
  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    this.searchField.val('');
    setTimeout(() => this.searchField.focus(), 301); // css transition-time の後
    this.isOverlayOpen = true;
  }

  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    this.isOverlayOpen = false;
  }

  typingLogic() {
    if (this.searchField.val() != this.previousValue) { // shiftキーなどは無視
      clearTimeout(this.typingTimer);

      if (this.searchField.val()) {
        // コアロジック
        if (!this.isSpinnerVisible) {
          this.resultDiv.html('<div class="spinner-loader"></div>');
          this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
        this.previousValue = this.searchField.val();
      } else { // 文字がなければローディング非表示
        this.resultDiv.html('');
        this.isSpinnerVisible = false;
      }
    }
  }

  getResults() {
    $.when(
      $.getJSON(universityData.root_url + "/wp-json/wp/v2/posts?search=" + this.searchField.val()),
      $.getJSON(universityData.root_url + "/wp-json/wp/v2/pages?search=" + this.searchField.val())
    ).then(
      (posts, pages) => {
        var combinedResults = posts[0].concat(pages[0])
        this.resultDiv.html(`
        <h2 class="search-overlay__section-title">General Information</h2>
        ${combinedResults.length ? '<ul class="link-list min-list">' : "<p>No general information matches that search.</p>"}
          ${combinedResults.map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join("")}
        ${combinedResults.length ? "</ul>" : ""}
      `)
        this.isSpinnerVisible = false
      },
      () => {
        this.resultDiv.html("<p>Unexpected error; please try again.</p>")
      }
    )
    
    this.isSpinnerVisible = false;
  }

  keyPressDispatcher(e) {
    // '/'
    if (e.keyCode == 191 && !this.isOverlayOpen && !$('input, textarea').is(':focus')) {
      this.openOverlay()
    }

    // 'esc'
    if (e.keyCode == 27 && this.isOverlayOpen) {
      this.closeOverlay()
    }
  }

  addSearchHtml() {
    $("body").append(`
    <div class="search-overlay">
        <div class="search-overlay__top">
            <div class="container">
                <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                <input type="text" class="search-term" placeholder="検索ワードを入力してください" id="search-term">
                <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
            </div>
        </div>

        <div class="container">
            <div id="search-overlay__results"></div>
        </div>
    </div>
    `)
  }
}

export default Search;