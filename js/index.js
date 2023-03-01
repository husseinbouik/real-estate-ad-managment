// Primary image upload
for (let i = 0; i < 5; i++) {
    const primaryUpload = document.getElementById(`fileUpload${i}`);
    const primaryPreview1 = document.getElementById(`previewImage1${i}`);
    const primaryIcon1 = document.getElementById(`icon1${i}`);
    
    primaryUpload.addEventListener("change", function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.addEventListener("load", function() {
                primaryPreview1.style.display = "block";
                primaryPreview1.setAttribute("src", this.result);
                primaryIcon1.style.display = "none";
            });
            reader.readAsDataURL(file);
        } else {
            primaryPreview1.style.display = "none";
            primaryPreview1.setAttribute("src", "#");
            primaryIcon1.style.display = "block";
        }
    });
    }
    
    // Secondary image uploads
    const secondaryUploads = document.querySelectorAll(".secondary-image-wrapper input[type=file]");
    const secondaryPreviews1 = document.querySelectorAll(".secondary-image-wrapper .previewImage");
    const secondaryIcons1 = document.querySelectorAll(".secondary-image-wrapper img:not(.previewImage)");
    
    secondaryUploads.forEach(function(input, index) {
        input.addEventListener("change", function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.addEventListener("load", function() {
                    secondaryPreviews1[index].style.display = "block";
                    secondaryPreviews1[index].setAttribute("src", this.result);
                    secondaryIcons1[index].style.display = "none";
                });
                reader.readAsDataURL(file);
            } else {
                secondaryPreviews1[index].style.display = "none";
                secondaryPreviews1[index].setAttribute("src", "#");
                secondaryIcons1[index].style.display = "block";
            }
        });
    });
    
    // Modified IDs for Secondary image uploads
    const secondaryPreviews2 = document.querySelectorAll(".secondary-image-wrapper .previewImage");
    const secondaryIcons2 = document.querySelectorAll(".secondary-image-wrapper img:not(.previewImage)");
    
    for (let i = 0; i < 5; i++) {
        const secondaryUpload = document.getElementById(`fileUpload${i}`);
        const secondaryPreview = secondaryPreviews2[i];
        const secondaryIcon = secondaryIcons2[i];
    
        secondaryUpload.addEventListener("change", function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.addEventListener("load", function() {
                    secondaryPreview.style.display = "block";
                    secondaryPreview.setAttribute("src", this.result);
                    secondaryIcon.style.display = "none";
                });
                reader.readAsDataURL(file);
            } else {
                secondaryPreview.style.display = "none";
                secondaryPreview.setAttribute("src", "#");
                secondaryIcon.style.display = "block";
            }
        });
    }
    