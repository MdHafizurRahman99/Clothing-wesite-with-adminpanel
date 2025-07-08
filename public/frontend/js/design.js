// Initialize Fabric.js canvas
const canvas = new fabric.Canvas('canvas', {
    selection: true,
    width: 600,
    height: 600
});

// Global variables
let sideObjects = {
    front: [],
    back: [],
    right: [],
    left: []
};
let currentSide = 'front';
let sideConfigs = [];
let pointerMarker = null;
let selectedColor = '#FFFFFF';

// Initialize pointer marker (crosshair)
function initPointerMarker() {
    pointerMarker = new fabric.Path('M -10 0 L 10 0 M 0 -10 L 0 10', {
        left: 0,
        top: 0,
        stroke: 'red',
        strokeWidth: 2,
        selectable: false,
        evented: false,
        opacity: 0.8
    });
    canvas.add(pointerMarker);
}

// Update pointer coordinates and marker position
function updatePointerCoordinates(e) {
    const pointer = canvas.getPointer(e.e);
    const x = Math.round(pointer.x);
    const y = Math.round(pointer.y);
    document.getElementById('coordinates').textContent = `X: ${x}, Y: ${y}`;

    if (pointerMarker) {
        pointerMarker.set({ left: x, top: y });
        canvas.renderAll();
    }
}

// Log coordinates to backend
function logCoordinates() {
    const pointer = canvas.getPointer();
    console.log(`Side: ${currentSide}, X: ${Math.round(pointer.x)}, Y: ${Math.round(pointer.y)}`);
    fetch('/api/save-coordinate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product_id: document.querySelector('.product-id').value,
            side: currentSide,
            x: Math.round(pointer.x),
            y: Math.round(pointer.y)
        })
    }).then(response => response.json()).then(data => {
        alert('Coordinates saved!');
    }).catch(error => {
        console.error('Error saving coordinates:', error);
    });
}

// Fetch side configurations
async function fetchSideConfigs(productId) {
    try {
        const response = await fetch(`/api/products/${productId}/sides`);
        sideConfigs = await response.json();
        return sideConfigs;
    } catch (error) {
        console.error('Error fetching side configurations:', error);
        return [];
    }
}

// Render adjacent side designs
async function renderAdjacentDesigns() {
    const currentConfig = sideConfigs.find(config => config.side === currentSide);
    if (!currentConfig || !currentConfig.adjacent_side_mappings[currentSide]) return;

    const mappings = currentConfig.adjacent_side_mappings[currentSide];
    mappings.forEach(mapping => {
        const adjacentSide = mapping.side;
        const objects = sideObjects[adjacentSide] || [];

        objects.forEach(obj => {
            fabric.util.enlivenObjects([obj], (clonedObjects) => {
                const clonedObj = clonedObjects[0];
                clonedObj.set({
                    left: mapping.x,
                    top: mapping.y,
                    scaleX: mapping.scale,
                    scaleY: mapping.scale,
                    angle: mapping.rotation,
                    opacity: 0.8,
                    selectable: false,
                    evented: false
                });

                const clipPath = new fabric.Rect({
                    left: currentConfig.design_area.x,
                    top: currentConfig.design_area.y,
                    width: currentConfig.design_area.width,
                    height: currentConfig.design_area.height,
                    absolutePositioned: true
                });
                clonedObj.clipPath = clipPath;

                canvas.add(clonedObj);
            });
        });
    });
}

// Change hoodie image and side
async function changeHoodieImage(side) {
    console.log(`Changing hoodie image to side: ${side}`);

    saveCurrentCanvasObjects();
    canvas.clear();
    currentSide = side;

    const productId = document.querySelector('.product-id').value;
    if (!sideConfigs.length) {
        await fetchSideConfigs(productId);
    }

    const sideConfig = sideConfigs.find(config => config.side === side);
    console.log(`Side configuration for ${side}:`, sideConfig);

    if (!sideConfig || !sideConfig.image_url) return;

    fabric.Image.fromURL(sideConfig.image_url, (img) => {
        const padding = 20;
        img.scaleToWidth(canvas.width - padding * 2);
        img.scaleToHeight(canvas.height - padding * 2);
        img.set({
            left: padding,
            top: padding,
            selectable: false
        });

        img.filters.push(new fabric.Image.filters.BlendColor({
            color: selectedColor,
            mode: 'overlay',
            alpha: 0.5
        }));
        img.applyFilters();

        canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));

        const designAreaRect = new fabric.Rect({
            left: sideConfig.design_area.x,
            top: sideConfig.design_area.y,
            width: sideConfig.design_area.width,
            height: sideConfig.design_area.height,
            fill: 'transparent',
            stroke: 'blue',
            strokeWidth: 2,
            selectable: false,
            evented: false,
            opacity: 0.5
        });
        canvas.add(designAreaRect);

        canvas.clipPath = new fabric.Rect({
            left: sideConfig.design_area.x,
            top: sideConfig.design_area.y,
            width: sideConfig.design_area.width,
            height: sideConfig.design_area.height,
            absolutePositioned: true
        });

        loadCurrentCanvasObjects();
        renderAdjacentDesigns();
        initPointerMarker();
    });
}

// Save canvas objects
function saveCurrentCanvasObjects() {
    sideObjects[currentSide] = canvas.getObjects().filter(obj => obj.selectable);
}

// Load canvas objects
function loadCurrentCanvasObjects() {
    const objects = sideObjects[currentSide] || [];
    objects.forEach(obj => canvas.add(obj));
    canvas.renderAll();
}

// Handle image uploads
        function addImage(imageURL) {
            fetch(imageURL)
                .then(res => res.blob())
                .then(blob => {
                    var productIdInput = document.querySelector('.product-id');
                    var productId = productIdInput.value;
                    var fileInput = document.getElementById('logoInput');
                    let formData = new FormData();
                    formData.append('product_id', productId);
                    formData.append('imageFile', blob, 'image.jpg');
                })
                .catch(error => {
                    console.error('Error converting data URL to Blob:', error);
                });

            const sleeveClipPath = new fabric.Rect({
                left: 198, // Adjust based on sleeve position
                top: 210, // Adjust based on sleeve position
                width: 178, // Adjust based on sleeve dimensions
                height: 175, // Adjust based on sleeve dimensions
                absolutePositioned: true,
            });
            fabric.Image.fromURL(
                imageURL,
                function(img) {
                    img.set({
                        top: 210,
                        left: 252,
                        scaleX: 0.2,
                        scaleY: 0.2,
                        selectable: true, // Image should be selectable
                        evented: true,
                    });
                    canvas.add(img);

                    saveCurrentCanvasObjects(); // Save the new object for the current side

                });
        }

        // Handle logo upload
        document.getElementById('logoInput').addEventListener('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();
            reader.onload = function(event) {
                var imageURL = event.target.result;
                addImage(imageURL);
            }
            reader.readAsDataURL(file);
            document.getElementById("logoInput").value = "";

        });
// document.getElementById('logoInput').addEventListener('change', function (e) {

//     const file = e.target.files[0];
//     const reader = new FileReader();
//     reader.onload = function (event) {
//         const imageURL = event.target.result;
//         console.log('Image URL:', imageURL);

//         const sideConfig = sideConfigs.find(config => config.side === currentSide);
//         if (!sideConfig) return;
//         console.log(`Uploading image for side: ${sideConfig ? sideConfig.side : 'unknown'}`);

//         fabric.Image.fromURL(imageURL, (img) => {
//             img.set({
//                 top: 210,
//                 left: 252,
//                 scaleX: 0.2,
//                 scaleY: 0.2,
//                 selectable: true,
//                 evented: true
//             });
//             canvas.add(img);
//             saveCurrentCanvasObjects();
//             canvas.renderAll();
//         });
//     };
//     reader.readAsDataURL(file);
//     document.getElementById('logoInput').value = '';
// });

// Delete selected object
function deleteAction() {
    const activeObject = canvas.getActiveObject();
    if (activeObject) {
        canvas.remove(activeObject);
        saveCurrentCanvasObjects();
        canvas.renderAll();
    }
}

// Save canvas to backend
async function saveCanvas(side) {
    const imageData = canvas.toDataURL({ format: 'png' });
    const formData = new FormData();
    formData.append('product_id', document.querySelector('.product-id').value);
    formData.append('side', side);
    formData.append('imageFile', dataURLtoBlob(imageData), 'image.png');
    formData.append('objects', JSON.stringify(sideObjects[side]));

    try {
        const response = await fetch('/api/mockups/generate', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });
        const data = await response.json();
        return data.mockup_url;
    } catch (error) {
        console.error('Error saving canvas:', error);
        throw error;
    }
}

function dataURLtoBlob(dataURL) {
    const [header, data] = dataURL.split(',');
    const mime = header.match(/:(.*?);/)[1];
    const binary = atob(data);
    const array = [];
    for (let i = 0; i < binary.length; i++) {
        array.push(binary.charCodeAt(i));
    }
    return new Blob([new Uint8Array(array)], { type: mime });
}

// Preview all sides
async function preview() {
    document.getElementById('mainContent').classList.add('blur-effect');
    const productId = document.querySelector('.product-id').value;
    const modalBody = $('#imageGalleryModal .modal-body .row');
    modalBody.empty();

    const sides = ['front', 'back', 'right', 'left'];
    for (const side of sides) {
        const sideConfig = sideConfigs.find(config => config.side === side);
        if (!sideConfig || !sideConfig.image_url) continue;

        const tempCanvas = new fabric.StaticCanvas(null, { width: 600, height: 600 });
        await new Promise((resolve) => {
            fabric.Image.fromURL(sideConfig.image_url, (img) => {
                const padding = 20;
                img.scaleToWidth(tempCanvas.width - padding * 2);
                img.scaleToHeight(tempCanvas.height - padding * 2);
                img.set({ left: padding, top: padding, selectable: false });

                img.filters.push(new fabric.Image.filters.BlendColor({
                    color: selectedColor,
                    mode: 'overlay',
                    alpha: 0.5
                }));
                img.applyFilters();

                tempCanvas.setBackgroundImage(img, tempCanvas.renderAll.bind(tempCanvas));
                sideObjects[side].forEach(obj => tempCanvas.add(obj));

                const mappings = sideConfig.adjacent_side_mappings[side] || [];
                mappings.forEach(mapping => {
                    const adjacentObjects = sideObjects[mapping.side] || [];
                    adjacentObjects.forEach(obj => {
                        fabric.util.enlivenObjects([obj], (clonedObjects) => {
                            const clonedObj = clonedObjects[0];
                            clonedObj.set({
                                left: mapping.x,
                                top: mapping.y,
                                scaleX: mapping.scale,
                                scaleY: mapping.scale,
                                angle: mapping.rotation,
                                opacity: 0.8,
                                selectable: false
                            });
                            tempCanvas.add(clonedObj);
                        });
                    });
                });

                tempCanvas.renderAll();
                const imageData = tempCanvas.toDataURL({ format: 'png', quality: 0.8 });
                modalBody.append(`
                    <div class="col-md-4">
                        <img src="${imageData}" class="img-fluid mb-2" alt="${side} Image" onclick="openZoomModal('${imageData}')">
                    </div>
                `);
                resolve();
            });
        });
    }

    $('#imageGalleryModal').modal('show');
}

// Design gallery functions
let designGallery = [];
function saveCurrentDesign() {
    const objects = canvas.getObjects().filter(obj => obj.selectable);
    const tempCanvas = new fabric.StaticCanvas(null, { width: 600, height: 600 });
    objects.forEach(obj => tempCanvas.add(obj));
    const previewImage = tempCanvas.toDataURL({ format: 'png', quality: 0.8 });

    const designs = JSON.parse(localStorage.getItem('designs')) || [];
    designs.push({ side: currentSide, objects: objects, preview: previewImage });
    localStorage.setItem('designs', JSON.stringify(designs));
    alert('Design saved successfully!');
}

function loadDesignGallery() {
    const modal = document.getElementById('design-modal');
    const galleryContainer = document.getElementById('modal-gallery');
    galleryContainer.innerHTML = '';

    const designs = JSON.parse(localStorage.getItem('designs')) || [];
    designs.forEach((design, index) => {
        const imgWrapper = document.createElement('div');
        imgWrapper.style.position = 'relative';

        const imgElement = document.createElement('img');
        imgElement.src = design.preview;
        imgElement.alt = `Design ${index + 1}`;
        imgElement.onclick = () => applyDesignToCanvas(design.objects);

        const removeBtn = document.createElement('span');
        removeBtn.className = 'remove-btn';
        removeBtn.innerHTML = 'X';
        removeBtn.onclick = () => removeDesign(index);

        imgWrapper.appendChild(imgElement);
        imgWrapper.appendChild(removeBtn);
        galleryContainer.appendChild(imgWrapper);
    });

    modal.style.display = 'flex';
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('inert');
}

function removeDesign(index) {
    const designs = JSON.parse(localStorage.getItem('designs')) || [];
    designs.splice(index, 1);
    localStorage.setItem('designs', JSON.stringify(designs));
    loadDesignGallery();
}

function applyDesignToCanvas(objects) {
    fabric.util.enlivenObjects(objects, (enlivenedObjects) => {
        enlivenedObjects.forEach(obj => canvas.add(obj));
        canvas.renderAll();
    });
    closeModal();
}

function closeModal() {
    const modal = document.getElementById('design-modal');
    modal.style.display = 'none';
    modal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('inert');
}

// Color picker
document.getElementById('colorPicker')?.addEventListener('input', function () {
    selectedColor = this.value;
    document.getElementById('customColorPicker').value = selectedColor;
    changeHoodieImage(currentSide);
});

// Form submission
document.getElementById('mockupForm').addEventListener('submit', async function (event) {
    event.preventDefault();
    const product = window.product;
    const sides = ['front', 'back', 'right', 'left'].filter(side => product[`design_image_${side}_side`]);
    for (const side of sides) {
        await changeHoodieImage(side);
        await saveCanvas(side);
    }
    this.submit();
});

// Track pointer movement
canvas.on('mouse:move', updatePointerCoordinates);

// Initialize
window.onload = async function () {
    const productId = document.querySelector('.product-id').value;
    await fetchSideConfigs(productId);
    changeHoodieImage('front');
};
