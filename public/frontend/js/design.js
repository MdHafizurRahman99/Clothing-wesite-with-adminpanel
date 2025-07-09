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
let leftObjects = [];
let rightObjects = [];
let leftSleeveLeftSide = null;
let leftSleeveRightSide = null;
let rightSleeveLeftSide = null;
let rightSleeveRightSide = null;
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
        Swal.fire('Success', 'Coordinates saved!', 'success');
    }).catch(error => {
        console.error('Error saving coordinates:', error);
        Swal.fire('Error', 'Failed to save coordinates.', 'error');
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
        Swal.fire('Error', 'Failed to load side configurations.', 'error');
        return [];
    }
}

// Add design to sleeve (your exact implementation)
function addDesignToSleeve(objects, side) {
    var productIdInput = document.querySelector('.product-id');
    var productId = productIdInput.value;
    if (productId == 'MPC-HAC200372749962') {
        var leftImage_left = 405;
        var leftImage_rotate = -11;
        var sleeve_top = 220;
        var leftImage_right = 436;
        var leftImage_right_rotate = -5;
        var rightImage_left = 30;
        var rightImage_rotate = 11;
        var rightImage_right = 86;
        var rightImage_right_rotate = 11;
    } else if (productId == 'MPC-SZCRepudiandae modi sun2038874817') {
        var leftImage_left = 480;
        var leftImage_rotate = -50;
        var sleeve_top = 138;
        var leftImage_right = 554;
        var leftImage_right_rotate = -53;
        var rightImage_left = 71;
        var rightImage_rotate = 51;
        var rightImage_right = 99;
        var rightImage_right_rotate = 53;
    }

    var tempCanvas = new fabric.StaticCanvas(null, {
        width: 600,
        height: 600,
    });

    objects.forEach(function(obj) {
        tempCanvas.add(obj);
    });

    var previewImage = tempCanvas.toDataURL({
        format: 'png',
        quality: 0.8,
    });
    var img = new Image();
    img.src = previewImage;

    return new Promise((resolve) => {
        img.onload = function() {
            var canvasTemp = document.createElement('canvas');
            var ctxTemp = canvasTemp.getContext('2d');

            canvasTemp.width = img.width;
            canvasTemp.height = img.height;

            ctxTemp.drawImage(img, 0, 0);

            var imageData = ctxTemp.getImageData(0, 0, canvasTemp.width, canvasTemp.height);
            var data = imageData.data;

            var left = canvasTemp.width,
                right = 0,
                top = canvasTemp.height,
                bottom = 0;

            for (var y = 0; y < canvasTemp.height; y++) {
                for (var x = 0; x < canvasTemp.width; x++) {
                    var index = (y * canvasTemp.width + x) * 4;
                    var alpha = data[index + 3];

                    if (alpha > 0) {
                        if (x < left) left = x;
                        if (x > right) right = x;
                        if (y < top) top = y;
                        if (y > bottom) bottom = y;
                    }
                }
            }

            var canvasCropped = document.createElement('canvas');
            var ctxCropped = canvasCropped.getContext('2d');
            canvasCropped.width = right - left;
            canvasCropped.height = bottom - top;

            ctxCropped.drawImage(canvasTemp, left, top, canvasCropped.width, canvasCropped.height, 0, 0,
                canvasCropped.width, canvasCropped.height);

            fabric.Image.fromURL(canvasCropped.toDataURL(), function(croppedImage) {
                var cutWidth = croppedImage.width / 2;
                var leftImage, rightImage;
                var canvasLeft = document.createElement('canvas');
                var ctxLeft = canvasLeft.getContext('2d');
                canvasLeft.width = cutWidth;
                canvasLeft.height = croppedImage.height;

                ctxLeft.drawImage(croppedImage.getElement(), 0, 0, cutWidth, croppedImage.height, 0, 0,
                    cutWidth, croppedImage.height);

                fabric.Image.fromURL(canvasLeft.toDataURL(), function(leftFabricImage) {
                    leftImage = leftFabricImage;

                    if (side == 'left') {
                        leftImage.set({
                            left: leftImage_left,
                            top: sleeve_top,
                        });
                        leftImage.scaleToWidth(20);
                        leftImage.rotate(leftImage_rotate);
                        leftSleeveLeftSide = leftImage;
                    } else {
                        leftImage.set({
                            left: leftImage_right,
                            top: sleeve_top,
                        });
                        leftImage.scaleToWidth(20);
                        leftImage.rotate(leftImage_right_rotate);
                        rightSleeveLeftSide = leftImage;
                        console.log(rightSleeveLeftSide);
                    }
                });

                var canvasRight = document.createElement('canvas');
                var ctxRight = canvasRight.getContext('2d');
                canvasRight.width = cutWidth;
                canvasRight.height = croppedImage.height;

                ctxRight.drawImage(croppedImage.getElement(), cutWidth, 0, cutWidth, croppedImage.height, 0,
                    0, cutWidth, croppedImage.height);

                fabric.Image.fromURL(canvasRight.toDataURL(), function(rightFabricImage) {
                    rightImage = rightFabricImage;

                    if (side == 'left') {
                        rightImage.set({
                            left: rightImage_left,
                            top: sleeve_top,
                        });
                        rightImage.scaleToWidth(20);
                        rightImage.rotate(rightImage_rotate);
                        leftSleeveRightSide = rightImage;
                    } else {
                        rightImage.set({
                            left: rightImage_right,
                            top: sleeve_top,
                        });
                        rightImage.scaleToWidth(20);
                        rightImage.rotate(rightImage_right_rotate);
                        rightSleeveRightSide = rightImage;
                        console.log(rightSleeveRightSide);
                    }
                    resolve();
                });
            });
        };
    });
}

// Change hoodie image and side
async function changeHoodieImage(side) {
    saveCurrentCanvasObjects();
    canvas.clear();
    currentSide = side;

    const productIdInput = document.querySelector('.product-id');
    const productId = productIdInput.value;

    if (!sideConfigs.length) {
        await fetchSideConfigs(productId);
    }

    const sideConfig = sideConfigs.find(config => config.side === side);
    if (!sideConfig || !sideConfig.image_url) {
        Swal.fire('Error', `No image available for ${side} side.`, 'error');
        return;
    }

    return new Promise((resolve) => {
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

            canvas.setBackgroundImage(img, () => {
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
                if (side === 'front' || side === 'back') {
                    const promises = [];
                    if (leftObjects.length > 0) {
                        promises.push(addDesignToSleeve(leftObjects, 'left'));
                    }
                    if (rightObjects.length > 0) {
                        promises.push(addDesignToSleeve(rightObjects, 'right'));
                    }

                    Promise.all(promises).then(() => {
                        if (side === 'front') {
                            if (leftSleeveLeftSide) canvas.add(leftSleeveLeftSide);
                            if (rightSleeveRightSide) canvas.add(rightSleeveRightSide);
                        } else if (side === 'back') {
                            if (leftSleeveRightSide) canvas.add(leftSleeveRightSide);
                            if (rightSleeveLeftSide) canvas.add(rightSleeveLeftSide);
                        }
                        initPointerMarker();
                        canvas.renderAll();
                        resolve();
                    });
                } else {
                    initPointerMarker();
                    canvas.renderAll();
                    resolve();
                }
            });
        });
    });
}

// Change side for preview (inferred from your context)
async function changeSideForPreview(side) {
    const tempCanvas = new fabric.StaticCanvas(null, { width: 600, height: 600 });
    const sideConfig = sideConfigs.find(config => config.side === side);
    if (!sideConfig || !sideConfig.image_url) {
        return tempCanvas;
    }

    return new Promise((resolve) => {
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

            tempCanvas.setBackgroundImage(img, () => {
                const objects = sideObjects[side] || [];
                let loadedObjects = 0;
                const totalObjects = objects.length;

                if (totalObjects === 0) {
                    resolve(tempCanvas);
                    return;
                }

                objects.forEach(obj => {
                    fabric.util.enlivenObjects([obj], (clonedObjects) => {
                        tempCanvas.add(clonedObjects[0]);
                        loadedObjects++;
                        if (loadedObjects === totalObjects) {
                            resolve(tempCanvas);
                        }
                    });
                });
            });
        });
    });
}

// Save canvas objects
function saveCurrentCanvasObjects() {
    sideObjects[currentSide] = canvas.getObjects().filter(obj => obj.selectable);
    if (currentSide === 'left') {
        leftObjects = sideObjects[currentSide];
    } else if (currentSide === 'right') {
        rightObjects = sideObjects[currentSide];
    }
}

// Load canvas objects
function loadCurrentCanvasObjects() {
    const objects = sideObjects[currentSide] || [];
    objects.forEach(obj => canvas.add(obj));
}

// Add image to canvas (your exact implementation)
function addImage(imageURL) {
    fetch(imageURL)
        .then(res => res.blob())
        .then(blob => {
            var productIdInput = document.querySelector('.product-id');
            var productId = productIdInput.value;
            var fileInput = document.getElementById('logoInput');
            let formData = new FormData();
            formData.append('product_id', productId);
            formData.append('side', currentSide);
            formData.append('imageFile', blob, 'image.jpg');
            formData.append('objects', JSON.stringify(sideObjects[currentSide]));

            return fetch('/api/mockups/generate', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });
        })
        .then(response => response.json())
        .then(data => {
            console.log('Image saved:', data.mockup_url);
        })
        .catch(error => {
            console.error('Error converting data URL to Blob:', error);
            Swal.fire('Error', 'Failed to save image.', 'error');
        });

    const sleeveClipPath = new fabric.Rect({
        left: 198,
        top: 210,
        width: 178,
        height: 175,
        absolutePositioned: true
    });

    fabric.Image.fromURL(
        imageURL,
        function(img) {
            img.set({
                top: 210,
                left: 252,
                scaleX: 0.2,
                scaleY: 0.2,
                selectable: true,
                evented: true,
                clipPath: sleeveClipPath
            });
            canvas.add(img);
            saveCurrentCanvasObjects();
            if (currentSide === 'left' || currentSide === 'right') {
                addDesignToSleeve(sideObjects[currentSide], currentSide).then(() => {
                    canvas.renderAll();
                });
            } else {
                canvas.renderAll();
            }
        });
}

// Handle logo upload (your exact implementation)
document.getElementById('logoInput').addEventListener('change', function(e) {
    var file = e.target.files[0];
    var reader = new FileReader();
    reader.onload = function(event) {
        var imageURL = event.target.result;
        addImage(imageURL);
    };
    reader.readAsDataURL(file);
    document.getElementById("logoInput").value = "";
});

// Delete selected object
function deleteAction() {
    const activeObject = canvas.getActiveObject();
    if (activeObject) {
        canvas.remove(activeObject);
        saveCurrentCanvasObjects();
        if (currentSide === 'left' || currentSide === 'right') {
            addDesignToSleeve(sideObjects[currentSide], currentSide).then(() => {
                canvas.renderAll();
            });
        } else {
            canvas.renderAll();
        }
    }
}

// Save canvas to backend
async function saveCanvas(side) {
    const tempCanvas = await changeSideForPreview(side);
    if (side === 'front') {
        if (leftSleeveLeftSide) tempCanvas.add(leftSleeveLeftSide);
        if (rightSleeveRightSide) tempCanvas.add(rightSleeveRightSide);
    } else if (side === 'back') {
        if (leftSleeveRightSide) tempCanvas.add(leftSleeveRightSide);
        if (rightSleeveLeftSide) tempCanvas.add(rightSleeveLeftSide);
    }
    tempCanvas.renderAll();
    const imageData = tempCanvas.toDataURL({ format: 'png', quality: 0.8 });

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
        Swal.fire('Error', 'Failed to save design.', 'error');
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

// Preview all sides (your implementation with Promises)
async function preview() {
    document.getElementById('mainContent').classList.add('blur-effect');
    var productIdInput = document.querySelector('.product-id');
    var productId = productIdInput.value;

    var front_image = '';
    var back_image = '';
    var right_image = '';
    var left_image = '';

    const promises = [];
    if (rightObjects.length > 0) {
        promises.push(addDesignToSleeve(rightObjects, 'right'));
    }
    if (leftObjects.length > 0) {
        promises.push(addDesignToSleeve(leftObjects, 'left'));
    }

    await Promise.all(promises);

    const sides = ['front', 'back', 'right', 'left'].filter(side => product[`design_image_${side}_side`]);

    for (const side of sides) {
        const tempCanvas = await changeSideForPreview(side);
        if (side === 'front') {
            if (leftSleeveLeftSide) tempCanvas.add(leftSleeveLeftSide);
            if (rightSleeveRightSide) tempCanvas.add(rightSleeveRightSide);
        }
        if (side === 'back') {
            if (leftSleeveRightSide) tempCanvas.add(leftSleeveRightSide);
            if (rightSleeveLeftSide) tempCanvas.add(rightSleeveLeftSide);
        }
        tempCanvas.renderAll();
        const imageData = tempCanvas.toDataURL({ format: 'png', quality: 0.8 });

        if (side === 'front') front_image = imageData;
        if (side === 'back') back_image = imageData;
        if (side === 'right') right_image = imageData;
        if (side === 'left') left_image = imageData;
    }

    var modalBody = $('#imageGalleryModal .modal-body .row');
    modalBody.empty();

    if (front_image) {
        modalBody.append(`
            <div class="col-md-4">
                <img src="${front_image}" class="img-fluid mb-2" alt="Front Image" onclick="openZoomModal('${front_image}')">
            </div>
        `);
    }

    if (back_image) {
        modalBody.append(`
            <div class="col-md-4">
                <img src="${back_image}" class="img-fluid mb-2" alt="Back Image" onclick="openZoomModal('${back_image}')">
            </div>
        `);
    }
    if (right_image) {
        modalBody.append(`
            <div class="col-md-4">
                <img src="${right_image}" class="img-fluid mb-2" alt="Right Image" onclick="openZoomModal('${right_image}')">
            </div>
        `);
    }
    if (left_image) {
        modalBody.append(`
            <div class="col-md-4">
                <img src="${left_image}" class="img-fluid mb-2" alt="Left Image" onclick="openZoomModal('${left_image}')">
            </div>
        `);
    }

    if (!front_image && !back_image && !right_image && !left_image) {
        modalBody.append(`
            <p class="text-center">No images available for preview.</p>
        `);
    }

    $('#imageGalleryModal').modal('show');
}

// Design gallery functions
let designGallery = [];
function saveCurrentDesign() {
    const objects = canvas.getObjects().filter(obj => obj.selectable);
    const tempCanvas = new fabric.StaticCanvas(null, { width: 600, height: 600 });
    let loadedImages = 0;
    const totalImages = objects.length;

    if (totalImages === 0) {
        Swal.fire('Error', 'No design to save.', 'error');
        return;
    }

    objects.forEach(obj => {
        fabric.util.enlivenObjects([obj], (clonedObjects) => {
            tempCanvas.add(clonedObjects[0]);
            loadedImages++;
            if (loadedImages === totalImages) {
                tempCanvas.renderAll();
                const previewImage = tempCanvas.toDataURL({ format: 'png', quality: 0.8 });
                const designs = JSON.parse(localStorage.getItem('designs')) || [];
                designs.push({ side: currentSide, objects: objects, preview: previewImage });
                localStorage.setItem('designs', JSON.stringify(designs));
                Swal.fire('Success', 'Design saved successfully!', 'success');
            }
        });
    });
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
    canvas.clear();
    loadCurrentCanvasObjects();
    fabric.util.enlivenObjects(objects, (enlivenedObjects) => {
        enlivenedObjects.forEach(obj => canvas.add(obj));
        saveCurrentCanvasObjects();
        if (currentSide === 'left' || currentSide === 'right') {
            addDesignToSleeve(sideObjects[currentSide], currentSide).then(() => {
                canvas.renderAll();
            });
        } else {
            canvas.renderAll();
        }
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
document.getElementById('colorPicker')?.addEventListener('input', function() {
    selectedColor = this.value;
    document.getElementById('customColorPicker').value = selectedColor;
    changeHoodieImage(currentSide);
});

// Form submission
document.getElementById('mockupForm').addEventListener('submit', async function(event) {
    event.preventDefault();
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
window.onload = async function() {
    const productIdInput = document.querySelector('.product-id');
    const productId = productIdInput.value;
    await fetchSideConfigs(productId);
    await changeHoodieImage('front');
};
