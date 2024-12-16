function toggleAccordion(index) {
    console.log('toggleAccordion ejecutado con index:', index);

    var contentRow = document.getElementById('accordionContent' + index);
    var path = document.getElementById('accordionPath' + index);

    if (contentRow.classList.contains('hidden')) {
        contentRow.classList.remove('hidden');
        path.setAttribute('d', 'M5 9l7 7 7-7');
    } else {
        contentRow.classList.add('hidden');
        path.setAttribute('d', 'M9 5l7 7-7 7');
    }
}