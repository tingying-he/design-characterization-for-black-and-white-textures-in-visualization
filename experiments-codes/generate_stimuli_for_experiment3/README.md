# Experiment 3 Stimulus Generator

This script is used to generate stimuli for Experiment 3 of the paper:
Design Characterization for Black-and-White Textures in Visualization
DOI: 10.1109/TVCG.2023.3326941

Original experiment code:
https://github.com/tingying-he/design-characterization-for-black-and-white-textures-in-visualization/tree/main/experiments-codes/experiment3

## Usage

Run: `generate_stimuli/generate_images.php`

You should then see: 

![screenshot.png.png](screenshot.png)
 
Click the Download button to download the images (`.svg`, `.png`) and the dataset corresponding to the stimuli (`.json`).

Generated files will appear in the following folders:

`generated_svg/`

`generated_png/`

`generated_json/`

## Notes for Replication

### Stimuli for formal trials and training trails

In order to get all the simulations we need for Experiment 3, we run `generate_images.php` **twice**. One for the formal trials and anther for the training trials.

Our configuration:

* **Formal:** How many trials do you want for each condition? 10
* **Training:** How many trials do you want for each condition? 30
Reason for 30: when participants answered incorrectly during the trainning, they were given a new chart. Therefore, a larger number of training stimuli was needed.

### Random data
The script generates charts using random data. As a result, the charts produced by this script will not be identical to those in the original study. This is intentional and aligns with our study design, which relied on randomized datasets for the stimuli.
If you need the exact stimuli used in the original study, they can be found here:
https://github.com/tingying-he/design-characterization-for-black-and-white-textures-in-visualization/tree/main/experiments-codes/experiment3/html/stimuli
