# Design Characterization for Black-and-White Textures in Visualization

This is a repository for all data and analysis scripts used in the paper "[Design Characterization for Black-and-White Textures in Visualization](https://doi.org/10.1109/TVCG.2023.3326941)", presented at [IEEE Visualization 2023](http://ieeevis.org/year/2023/welcome) and published in the journal [IEEE Transactions on Visualization and Computer Graphics](https://ieeexplore.ieee.org/xpl/RecentIssue.jsp?punumber=2945). If you use the results in new projects or use it in a different way we would appreciate a citation:

Tingying He, Yuanyang Zhong, Petra Isenberg, and Tobias Isenberg. Design Characterization for Black-and-White Textures in Visualization. IEEE Transactions on Visualization and Computer Graphics, 2024. To appear. doi: [10.1109/TVCG.2023.3326941](https://doi.org/10.1109/TVCG.2023.3326941); open-access versions are available at [HAL](https://inria.hal.science/hal-04167900) and at [arXiv](https://arxiv.org/abs/2307.10089).


**Abstract:**
We investigate the use of 2D black-and-white textures for the visualization of categorical data and contribute a summary of texture attributes, and the results of three experiments that elicited design strategies as well as aesthetic and effectiveness measures. Black-and-white textures are useful, for instance, as a visual channel for categorical data on low-color displays, in 2D/3D print, to achieve the aesthetic of historic visualizations, or to retain the color hue channel for other visual mappings. We specifically study how to use what we call geometric textures Geometric textures and iconic textures Iconic textures. Geometric textures use patterns of repeated abstract geometric shapes, while iconic textures use repeated icons that may stand for data categories. We parameterized both types of textures and developed a tool for designers to create textures on simple charts by adjusting texture parameters. 30 visualization experts used our tool and designed 66 textured bar charts, pie charts, and maps. We then had 150 participants rate these designs for aesthetics. Finally, with the top-rated geometric and iconic textures, our perceptual assessment experiment with 150 participants revealed that textured charts perform about equally well as non-textured charts, and that there are some differences depending on the type of chart.

## BibTex

```
@article{He:2024:DCB,
  author      = {Tingying He and Yuanyang Zhong and Petra Isenberg and Tobias Isenberg},
  title       = {Design Characterization for Black-and-White Textures in Visualization},
  journal     = {IEEE Transactions on Visualization and Computer Graphics},
  year        = {2024},
  doi         = {10.1109/TVCG.2023.3326941},
  doi_url     = {https://doi.org/10.1109/TVCG.2023.3326941},
  oa_hal_url  = {https://hal.inria.fr/hal-04167900},
  preprint    = {https://doi.org/10.48550/arXiv.2307.10089},
  osf_url     = {https://osf.io/n5zut/},
  url         = {https://tobias.isenberg.cc/VideosAndDemos/He2024DCB},
  github_url  = {https://github.com/tingying-he/design-characterization-for-black-and-white-textures-in-visualization},
  pdf         = {https://tobias.isenberg.cc/personal/papers/He_2024_DCB.pdf},
  video       = {https://youtu.be/PfhSx-n02so},
}
```

## Project websites

* https://tingying-he.github.io/projects/He_2024_Textures.html
* https://tobias.isenberg.cc/VideosAndDemos/He2024DCB
* https://www.aviz.fr/Research/BWTextures

## Instructions for generating figures ([Graphics Replicability Stamp](https://www.replicabilitystamp.org/))
### Requirements

The R script contained within this repository requires, in addition to a normal R installation, several packages including (potentially more):

* `plyr`
* `dplyr`
* `tidyr`

To install these required packages, run the following call from a command line: `Rscript -e "install.packages(c('plyr', 'dplyr', 'tidyr'), repos='https://cran.rstudio.com')"`

### Running the R script

1. Clone this repository using `git clone git@github.com:tingying-he/design-characterization-for-black-and-white-textures-in-visualization.git` or download the code as a ZIP file from the repository.
2. Change to the cloned directory, and then navigate to the `graphics-replicability-stamp` folder by using the command `cd graphics-replicability-stamp`. All files related to the Graphics Replicability Stamp Initiative are stored in this folder.
3. Once you are in the `graphics-replicability-stamp` directory, knit the `all-exp2-exp3-figures.Rmd` file by running `Rscript -e "library(rmarkdown); rmarkdown::render('./all-exp2-exp3-figures.Rmd', 'html_document')"`

### Files produced

After the script completes, in the `graphics-replicability-stamp/results` folder you should see the following figures from [the paper](https://tingying-he.github.io/assets/publications/papers/He_2024_Textures.pdf) in PDF format.

* Fig. 4 
  * Figure4a-exp2_beauvis_bar.pdf
  * Figure4b-exp2_beauvis_pie.pdf
  * Figure4c-exp2_beauvis_map.pdf
  * Figure4d-exp2_beauvis_diff_bar.pdf
  * Figure4e-exp2_beauvis_diff_pie.pdf
  * Figure4f-exp2_beauvis_diff_map.pdf
* Fig. 5
  * Figure5a-exp2_vibratory_bar.pdf
  * Figure5b-exp2_vibratory_pie.pdf
  * Figure5c-exp2_vibratory_map.pdf
  * Figure5d-exp2_vibratory_diff_bar.pdf
  * Figure5e-exp2_vibratory_diff_pie.pdf
  * Figure5f-exp2_vibratory_diff_map.pdf
* Fig. 6
  * Figure6a-exp3_correct_rate_bar.pdf
  * Figure6b-exp3_correct_rate_pie.pdf
  * Figure6c-exp3_correct_rate_diff_bar.pdf
  * Figure6d-exp3_correct_rate_diff_pie.pdf
* Fig. 7
  * Figure7a-exp3_response_time_bar.pdf
  * Figure7b-exp3_response_time_pie.pdf
  * Figure7c-exp3_response_time_diff_bar.pdf
  * Figure7d-exp3_response_time_diff_pie.pdf
* Fig. 8
  * Figure8a-exp3_readable_bar.pdf
  * Figure8b-exp3_readable_pie.pdf
  * Figure8c-exp3_readable_diff_bar.pdf
  * Figure8d-exp3_readable_diff_pie.pdf
* Fig. 9
  * Figure9a-exp3_beauvis_bar.pdf
  * Figure9b-exp3_beauvis_pie.pdf
  * Figure9c-exp3_beauvis_diff_bar.pdf
  * Figure9d-exp3_beauvis_diff_pie.pdf

We were unable to script the other images in our paper, as they are design samples created by participants or old visualization examples.