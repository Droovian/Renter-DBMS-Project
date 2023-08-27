const drop_down = document.getElementById('dropbutton');
const the_div = document.getElementById('container');

drop_down.addEventListener('mouseover', ()=>{
    the_div.style.display = 'flex';
})

the_div.addEventListener('mouseover', ()=>{
    the_div.style.display = 'flex';
})

the_div.addEventListener('mouseout', ()=>{
    the_div.style.display = 'none';
})