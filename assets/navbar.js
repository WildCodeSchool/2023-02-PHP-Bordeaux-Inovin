let degustationsTitle = document.querySelector('.iv-nav-degustations')
let checkDegustations = false
function closeMenu() {
    checkDegustations = false
    checkAssemblages = false
    checkProfil= false
    degustationsTitle.style.display = 'none'
    assemblagesTitle.style.display = 'none'
    profilTitle.style.display = 'none'
}
function onOverDegustations() {
    if (checkDegustations === false) {
        checkDegustations = true
        degustationsTitle.style.display = 'block'
    } else {
        checkDegustations = false
        degustationsTitle.style.display = 'none'
    }
}
let assemblagesTitle = document.querySelector('.iv-nav-assemblages')
let checkAssemblages = false
function onOverAssemblages() {
    if (checkAssemblages === false) {
        checkAssemblages = true
        assemblagesTitle.style.display = 'block'
    } else {
        checkAssemblages = false
        assemblagesTitle.style.display = 'none'
    }
}
let profilTitle = document.querySelector('.iv-nav-profil')
let checkProfil = false
function onOverProfil() {
    if (checkProfil === false) {
        checkProfil = true
        profilTitle.style.display = 'block'
    } else {
        checkProfil = false
        profilTitle.style.display = 'none'
    }
}
