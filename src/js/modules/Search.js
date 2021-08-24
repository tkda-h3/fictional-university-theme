import $ from 'jquery';

class Search {
  // 1. init
  constructor() {
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
    this.resultDiv.html('search result here.. haha');
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
}

export default Search;