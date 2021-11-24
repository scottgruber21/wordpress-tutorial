import $ from 'jquery'

class Search{

    //1. Describe and create/initiate our object
    constructor(){
        this.addSearchHTML()
        this.openButton = $('.js-search-trigger');
        this.closeButton = $('.search-overlay__close');
        this.searchOverlay = $('.search-overlay');
        this.searchField = $("#search-term")
        this.resultsDiv = $('#search-overlay__results')
        this.events();
        this.isOverlayOpen = false;
        this.isSpinnerVisible = false
        this.typingTimer;
        this.previousValue;
    }

    //2. Events
    events(){
        this.openButton.on('click', this.openOverlay.bind(this))

        this.closeButton.on('click', this.closeOverlay.bind(this))

        $(document).on('keydown', this.keyPressDispatcher.bind(this))

        this.searchField.on("keyup", this.typingLogic.bind(this))
    }

    //3. Methods

    typingLogic(){
        if(this.previousValue !== this.searchField.val()){
            clearTimeout(this.typingTimer)

            if(this.searchField.val()){
                if(!this.isSpinnerVisible){
                this.resultsDiv.html('<div class="spinner-loader"></div>')
                this.isSpinnerVisible = true
            }
            this.typingTimer = setTimeout(this.getResults.bind(this), 500)
            }
            else{
                this.resultsDiv.html('')
                this.isSpinnerVisible = false
            }

            this.previousValue = this.searchField.val()
        }
    }

    getResults(){
        $.getJSON(universityData.root_url + '/wp-json/university/v1/search?term=' + this.searchField.val(), results => {
            this.resultsDiv.html(`
            <div class="row">
    <div class="one-third">
        <h2 class="search-overlay__section-title">General Information</h2>
         ${results.generalInfo.length > 0 ? `<ul class="link-list min-list">
            ${results.generalInfo.map(post => `<li><a href="${post.URL}">${post.title}</a>${post.postType == 'post' ? ' by ' + post.authorName : ''}</li>`).join('')}
            </ul>` : ``}
    </div>
    <div class="one-third">
        <h2 class="search-overlay__section-title">Programs</h2>
         ${results.programs.length > 0 ? `<ul class="link-list min-list">
            ${results.programs.map(post => `<li><a href="${post.URL}">${post.title}</a></li>`).join('')}
            </ul>`: ''}
        <h2 class="search-overlay__section-title">Professors</h2>
         ${results.professors.length > 0 ? `<ul class="professor-cards">
            ${results.professors.map(item => `
                <li class="professor-card__list-item">

                <a class="professor-card" href="${item.URL}">
                
                <img class="professor-card__image" src="${item.image}">
                
                <span class="professor-card__image">
                ${item.title}
                </span>
                    </a>
                </li>
            `).join('')}
            </ul>`: ''}
    </div>
    <div class="one-third">
        <h2 class="search-overlay__section-title">Campuses</h2>
         ${results.campuses.length > 0 ? `<ul class="link-list min-list">
            ${results.campuses.map(post => `<li><a href="${post.URL}">${post.title}</a></li>`).join('')}
            </ul>`: ''}
        <h2 class="search-overlay__section-title">Events</h2>
        ${results.events.length ? '' : `<p>No events match that search</p>`}
         ${results.events.map(item =>
            `
            <div class="event-summary">
    <a class="event-summary__date t-center" href="${item.URL}">
        <span class="event-summary__month">
            ${item.month}    
        </span>
        <span class="event-summary__day">${item.day}</span>
    </a>
    <div class="event-summary__content">
        <h5 class="event-summary__title headline headline--tiny"><a href="${item.URL}">${item.title}</a></h5>
        <p>${item.description}<a href="${item.URL}" class="nu gray">Learn more</a></p>
    </div>
</div>
            `
         ).join('')}
    </div>
</div>
            `);
        })
}

    openOverlay(){
        this.searchOverlay.addClass("search-overlay--active")
        $("body").addClass("body-no-scroll")
        this.isOverlayOpen = true;
        this.searchField.val('')
        setTimeout(() =>  this.searchField.focus(), 300)
        return false
    }

    closeOverlay(){
        this.searchOverlay.removeClass("search-overlay--active") 
        $("body").removeClass("body-no-scroll")
        this.isOverlayOpen = false;
    }

    keyPressDispatcher(e){
        if(e.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea".is(':focus'))){
            this.openOverlay()
        }
        if(e.keyCode == 27 && this.isOverlayOpen){
            this.closeOverlay()
        }
    }

addSearchHTML(){
        $('body').append(`
          <div class="search-overlay">
      <div class="search-overlay__top">
          <div class="container">
              <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
              <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
              <i class="fa fa-window-close search-overlay__close" aria-hidden="true" autocomplete="off"></i>
          </div>
      </div>
      <div class="container">
          <div id="search-overlay__results"></div>
      </div>
  </div>
        `)
    }
}

export default Search