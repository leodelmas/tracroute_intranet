document.addEventListener('DOMContentLoaded', (event) => {
    let addItemLink = document.querySelector("button.add_item_link");
    if(addItemLink) {
        addItemLink.addEventListener("click", function(e) {
            let collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
            let item = document.createElement('li');
            item.classList.add('d-flex', 'justify-content-between')
            item.innerHTML = collectionHolder.dataset.prototype.replace(/__name__/g, collectionHolder.dataset.index);
            collectionHolder.appendChild(item);
            addTagFormDeleteLink(item)
            collectionHolder.dataset.index ++;
        }, false);
    }
    let seriesList = document.querySelector('ul.invoiceLines');
    if (seriesList) {
        for (let series of seriesList.getElementsByTagName('li')) {
            addTagFormDeleteLink(series)
        }
    }
    function addTagFormDeleteLink (tagFormLi) {
        let removeFormButtonWrapper = document.createElement('div');
        removeFormButtonWrapper.classList.add('col-sm-1', 'm-auto');
        let removeFormButton = document.createElement('button');
        removeFormButton.classList.add('btn', 'btn-primary');
        removeFormButton.innerHTML = '-'
        removeFormButtonWrapper.append(removeFormButton);
        tagFormLi.append(removeFormButtonWrapper);
        removeFormButton.addEventListener('click', (e) => {
            e.preventDefault()
            tagFormLi.remove();
        });
    }
})