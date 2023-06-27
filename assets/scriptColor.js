function strToDom(str) {
  return document.createRange().createContextualFragment(str).firstElementChild;
}

class Point {
    constructor(x, y) {
        this.x = x;
        this.y = y;
    }
    toSvgPath() {
        return `${this.x} ${this.y}`;
    }
    static fromAngle(angle) {
        return new Point(Math.cos(angle), Math.sin(angle));
    }
}

let pourpre = ['#B9838A', 'pourpre']
let cerise = ['#E791A3', 'cerise']
let grenat = ['#C73630', 'grenat']
let tuile = ['#D88E35', 'tuilé']
let ambre = ['#B76831', 'ambré']
let vert = ['#F0EDB3', 'vert']
let blanc = ['#F6EFD9', 'blanc']
let dore = ['#F6E45E', 'doré']
let paille = ['#EACB50', 'paille']
let roux = ['#D6B065', 'roux']

class Piechart extends HTMLElement {
    constructor() {
        super();
        const shadow = this.attachShadow({mode: 'open'});
        let colors;
        for (let i = 1; i <= 4; i++) {
            if (document.querySelector('.colorCepage' + i).innerText === "Blanc") {
                colors = [vert, blanc, dore, paille, roux];
            } else {
                colors = [pourpre, cerise, grenat, tuile, ambre];
            }

        }

        this.data = this.getAttribute('data').split(';').map(v => parseFloat(v));
        const svg = strToDom(`<svg viewBox="-1 -1 2 2">
            <g class="pathGroup" mask="url(#graphMask)"></g>
            <mask class="maskGroup" id="graphMask">
            <rect fill="white" x="-1" y="-1" width="2" height="2"/>
            <circle r="0.5" fill="black"/>
            </mask>
            </svg>`);
        const pathGroup = svg.querySelector('.pathGroup');
        const maskGroup = svg.querySelector('.maskGroup');

        // On crée les chemins
        this.paths = this.data.map((_, k) => {
            const color = colors[k % (colors.length)][0];
            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            const colorName = colors[k % (colors.length)][1];
            path.setAttribute('fill', color);
            path.setAttribute('data-color', colorName);
            pathGroup.appendChild(path);
            return path;
        });


        this.lines = this.data.map((_, k) => {
            const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
            line.setAttribute('stroke', '#000');
            line.setAttribute('stroke-width', '0.1');
            line.setAttribute('x1', '0');
            line.setAttribute('y1', '0');
            maskGroup.appendChild(line);
            return line;
        });
        const style = document.createElement('style');
        style.innerHTML = `:host {display: block;position:relation;}
                              path {
                                  cursor: pointer;
                                  transition:opacity .3s;
                                  border-width:2px;
                                  border:solid;
                                  border-color:black;
                              }
                              svg {
                                   width:100%;
                                   height:100%
                              }
                              path:hover{
                                   opacity:0.5;
                              }`
        shadow.appendChild(style)
        shadow.appendChild(svg);
        // Ajouter l'écouteur d'événement de clic sur les chemins
        this.paths.forEach(path => {
            path.addEventListener('click', this.handleClick.bind(this));
        });
    }

    connectedCallback() {
        const now = Date.now()
        const duration = 1000
        const draw = () => {
            const t = (Date.now() - now) / duration;
            if (t < 1) {
                this.draw(t);
                window.requestAnimationFrame(draw);
            }
        }
        window.requestAnimationFrame(draw);
    }

    draw(progress = 1) {
        const total = this.data.reduce((acc, v) => acc + v, 0);
        let angle = 0;
        let start = new Point(1, 0);
        for (let k = 0; k < this.data.length; k++) {
            const ratio = (this.data[k] / total) * progress;
            angle += ratio * 2 * Math.PI;
            const end = Point.fromAngle(angle);
            const largeFlag = ratio >= 0.5 ? '1' : '0';
            this.paths[k].setAttribute('d', `M 0 0 L ${start.toSvgPath()} A 1 1 0 ${largeFlag} 1 ${end.toSvgPath()} L 0 0`);
            this.lines[k].setAttribute('x2', end.x);
            this.lines[k].setAttribute('y2', end.y);
            start = end;
        }
    }

    handleClick(event) {
        const color = event.target.getAttribute('data-color');
        const input = document.querySelector('.tasting_sheet_color1');
        if (input) {
            input.value = color; // Remplir le champ de saisie avec la couleur
        }
        const input2 = document.querySelector('.tasting_sheet_color2');
        if (input2) {
            input2.value = color; // Remplir le champ de saisie avec la couleur
        }
        const input3 = document.querySelector('.tasting_sheet_color3');
        if (input3) {
            input3.value = color; // Remplir le champ de saisie avec la couleur
        } const input4 = document.querySelector('.tasting_sheet_color4');
        if (input4) {
            input4.value = color; // Remplir le champ de saisie avec la couleur
        }

    }
}

customElements.define('pie-chart', Piechart);


