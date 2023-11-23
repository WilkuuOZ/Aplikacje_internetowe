


interface Styl {
    nazwa: string;
    plik: string;
  }
  
  
  function zmieńStyl(nowyStyl: Styl): void {
    
    const stareLinkiDoStyli = document.querySelectorAll('link[data-styl]');
    stareLinkiDoStyli.forEach((link) => link.parentNode?.removeChild(link));
  
    
    const nowyLinkDoStylu = document.createElement('link');
    nowyLinkDoStylu.rel = 'stylesheet';
    nowyLinkDoStylu.href = nowyStyl.plik;
    nowyLinkDoStylu.setAttribute('data-styl', nowyStyl.nazwa);
    document.head.appendChild(nowyLinkDoStylu);
  
    
    dodajLinkDoStyluWDivie(nowyStyl);
  }
  
  
  function obsłużKliknięcieLinka(event: Event, style: Styl[]): void {
    event.preventDefault();
    const nowaNazwaStylu = (event.target as HTMLAnchorElement).dataset.styl;
    const nowyStyl = style.find((s) => s.nazwa === nowaNazwaStylu);
    if (nowyStyl) {
      zmieńStyl(nowyStyl);
    }
  }
  



function dodajLinkDoStyluWDivie(styl: Styl): void {
    const divZLinkami = document.getElementById('linki-styli');
    if (divZLinkami) {
    
      if (!divZLinkami.querySelector(`a[data-styl="${styl.nazwa}"]`)) {
        const nowyLink = document.createElement('a');
        nowyLink.href = '#';
        nowyLink.dataset.styl = styl.nazwa;
        nowyLink.textContent = `Styl ${styl.nazwa.charAt(0).toUpperCase() + styl.nazwa.slice(1)}`+" ";
        nowyLink.addEventListener('click', (event) => obsłużKliknięcieLinka(event, style));
        divZLinkami.appendChild(nowyLink);
      }
    }
  }
  
  
  
  
  document.addEventListener('DOMContentLoaded', () => {
    zainicjujAplikację(style);
  
    
    const divZLinkami = document.getElementById('linki-styli');
    if (divZLinkami) {
      style.forEach((styl) => dodajLinkDoStyluWDivie(styl));
    }
  });
  
  
  
  function zainicjujAplikację(style: Styl[]): void {
   
    const linkiStyli = document.querySelectorAll('a[data-styl]');
    linkiStyli.forEach((link) => {
      link.addEventListener('click', (event) => obsłużKliknięcieLinka(event, style));
    });
  }
  
  //STYLE
  const style: Styl[] = [
    { nazwa: 'domyslny', plik: 'styles/style1.css' },
    { nazwa: 'lepszy', plik: 'styles/style2.css' },
    { nazwa: 'super',plik:"styles/style3.css"},
    { nazwa: 'DoScreena',plik:""}

  ];
  
  // Zainicjuj aplikację po załadowaniu DOM
  document.addEventListener('DOMContentLoaded', () => {
    zainicjujAplikację(style);
  
    // Dodaj linki do stylów z listy do sekcji div
    const divZLinkami = document.getElementById('linki-styli');
    if (divZLinkami) {
      style.forEach((styl) => dodajLinkDoStyluWDivie(styl));
    }
  });
  