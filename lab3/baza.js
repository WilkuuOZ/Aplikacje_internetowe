let map = L.map('map').setView([53.430127, 14.564802], 18);
L.tileLayer.provider('Esri.WorldImagery').addTo(map);

document.getElementById("saveButton").addEventListener("click", function() {
    leafletImage(map, function (err, canvas) {
        const rasterMap = document.getElementById("rasterMap");
        rasterMap.width = canvas.width;
        rasterMap.height = canvas.height;
        const rasterContext = rasterMap.getContext("2d");
        rasterContext.drawImage(canvas, 0, 0, canvas.width, canvas.height);

        createPuzzlePieces(rasterMap, 4, 4);
    });
});

document.getElementById("getLocation").addEventListener("click", function(event) {
    if (!navigator.geolocation) {
        console.log("No geolocation.");
    } else {
        navigator.geolocation.getCurrentPosition(
            position => {
                console.log(position);
                let lat = position.coords.latitude;
                let lon = position.coords.longitude;

                map.setView([lat, lon]);
                
                
                L.marker([lat, lon]).addTo(map)
                    .bindPopup("Hej, tu jesteś").openPopup();
            },
            positionError => {
                console.error(positionError);
            }
        );
    }
});

let puzzlePieces;

function createPuzzlePieces(image, rows, cols) {
    const puzzleWidth = image.width / cols;
    const puzzleHeight = image.height / rows;
    puzzlePieces = [];

    for (let row = 0; row < rows; row++) {
        for (let col = 0; col < cols; col++) {
            const canvas = document.createElement("canvas");
            const context = canvas.getContext("2d");

            canvas.width = puzzleWidth;
            canvas.height = puzzleHeight;

            context.drawImage(
                image,
                col * puzzleWidth,
                row * puzzleHeight,
                puzzleWidth,
                puzzleHeight,
                0,
                0,
                puzzleWidth,
                puzzleHeight
            );

            puzzlePieces.push({ canvas, correctPosition: { row, col } });
        }
    }
    shufflePuzzlePieces();
    displayPuzzlePieces(puzzlePieces);
}

function shufflePuzzlePieces() {
    for (let i = puzzlePieces.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [puzzlePieces[i], puzzlePieces[j]] = [puzzlePieces[j], puzzlePieces[i]];
    }
}

function displayPuzzlePieces(pieces) {
    const board = document.querySelector('.board');
    board.innerHTML = "";

    pieces.forEach((piece, index) => {
        let puzzlePiece = document.createElement("div");
        puzzlePiece.className = "puzzle-piece";
        puzzlePiece.draggable = true;
        puzzlePiece.setAttribute("data-index", index);

        puzzlePiece.style.backgroundImage = `url(${piece.canvas.toDataURL()})`;

        puzzlePiece.addEventListener("dragstart", dragStart);
        puzzlePiece.addEventListener("dragover", dragOver);
        puzzlePiece.addEventListener("drop", drop);

        board.appendChild(puzzlePiece);
    });
}

function dragStart(event) {
    event.dataTransfer.setData("text/plain", event.target.getAttribute("data-index"));
}

function dragOver(event) {
    event.preventDefault();
}

function drop(event) {
    event.preventDefault();
    const fromIndex = event.dataTransfer.getData("text/plain");
    const toIndex = event.target.getAttribute("data-index");

    if (fromIndex !== toIndex) {
        swapPuzzlePieces(parseInt(fromIndex), parseInt(toIndex));
        displayPuzzlePieces(puzzlePieces);

        if (puzzleIsComplete()) {
            alert("Puzzle is complete!");
        }
    }
}

function swapPuzzlePieces(fromIndex, toIndex) {
    const tempCanvas = puzzlePieces[fromIndex].canvas;
    puzzlePieces[fromIndex].canvas = puzzlePieces[toIndex].canvas;
    puzzlePieces[toIndex].canvas = tempCanvas;
}

function puzzleIsComplete() {
    return puzzlePieces.every((piece, index) => piece.correctPosition.row === Math.floor(index / 4) && piece.correctPosition.col === index % 4);
}

function createPuzzleZones(rows, cols) {
    const puzzleZones = [];

    for (let row = 0; row < rows; row++) {
        for (let col = 0; col < cols; col++) {
            const zone = document.createElement("div");
            zone.className = "puzzle-zone";
            zone.setAttribute("data-row", row);
            zone.setAttribute("data-col", col);
            rasterMapCanvas.appendChild(zone);
            puzzleZones.push(zone);
        }
    }

    return puzzleZones;
}

function isDropAllowed(fromIndex, toIndex) {
    const fromPiece = puzzlePieces[fromIndex];
    const toPiece = puzzlePieces[toIndex];
    const fromZone = puzzleZones[fromPiece.correctPosition.row * 4 + fromPiece.correctPosition.col];
    const toZone = puzzleZones[toPiece.correctPosition.row * 4 + toPiece.correctPosition.col];
    
    return fromZone === toZone;
}