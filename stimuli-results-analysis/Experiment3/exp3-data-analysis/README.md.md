This folder includes the data and analysis scripts for Experiment 3. We have encrypted the original prolific IDs of participants, converting them to new unique IDs.

## Contents of this folder

1. The `final_data` folder contains all the original data.
2. The `CI-analysis` folder contains pre-processed data and scripts for generating CI (Confidence Interval) graphs.

## How to use the scripts?

1. Run `Prolific_id_encryption.ipynb` to encrypt the prolific IDs (this step has already been completed).
2. Run `exp3_data_analysis-main.ipynb` to obtain basic information about this experiment, such as demographic information, distribution of timed-out trials, high-accuracy participants, etc., and to prepare data for CI analysis.
3. In the `CI-analysis` folder, run R scripts to generate the CI graphs for correct rate, response time, BeauVis score, and readability.