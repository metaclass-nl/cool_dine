

function Search(searchform) {

    this.searchform = searchform;

    // Init filter checkboxes
    $(this.searchform).find('.filter-option-input').change(this.filterOptionChanged.bind(this));
    $(this.searchform.search_text).keyup(this.keyUp.bind(this));
    $(this.searchform).find('.filter-range-input').keyup(this.keyUp.bind(this));
    $(this.searchform).find('select').change(this.selectChanged.bind(this));
}

Search.prototype.filterOptionChanged = function(event)
{
    this.sendSearchform(this.searchform);
}

Search.prototype.selectChanged= function(event)
{
    this.sendSearchform(this.searchform);
}

Search.prototype.sendSearchform = function () {
    this.searchform.submit();
}

Search.prototype.keyUp = function(event) {
    if(event.which == 13) {
        this.searchform.submit();
    }
}

$(document).ready(function () {
    new Search(document.searchform);
});