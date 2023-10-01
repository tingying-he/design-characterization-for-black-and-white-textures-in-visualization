* filter example related files: config folder, stimulus_page.php


# Framework for Running Online Experiments
FROE is a small framework to help realize online studies with explicit support for Prolific. The only requirement is a server running PHP.

## Provenance of this framework
This framework came together over the course of several years as a result of running different studies on different platforms such Amazon Mechanical Turk, Crowdflower, and lately Prolific. Since the latter is explicitly intended for running online studies, this framework only directly supports Prolific. However, it could be easily adapted to run with other platforms.

### Contributors
Three people contributed to the code in this framework:
- Luiz Augusto Morais
- Pierre Dragicevic
- Yvonne Jansen



## Features
- Integration with the Prolific platform
	- Participants don't need to enter their id manually and can click a link to validate the completion of the study on the platform.
	- Only participants who pass the attention check will be presented with a confirmation link. Consequently, participants who completed the study with the link are valid participants and can be confirmed for payment on Prolific. Only those who manually indicated the completion of the study need to be checked explicitly for having completed the study correctly.
- Logging
	- Multiple log files are generated to facilitate debugging of the experiment and to facilitate figuring out what went wrong if a participant complaints about their experience.
		- Results.csv is the main results file for analysis
		- Requested.csv contains basic information for all who requested the page
		- Consent.csv contains all participants who accepted the conditions detailed in the consent form
		- Excluded.csv contains information about participants who were excluded (mostly for reloading the page despite being intructed and warned not to)
		- Individual/ is a folder containing individual log files for each participant where each row contains the data sent after clicking a next button. These are usually only needed when something goes wrong. They could also be used to detect on which page participants drop out.
	- Automatic logging of participant ids, their browser versions, and timestamps for each page.
- Randomized assignment of participants to conditions
- Checking of browser versions and ensuring minimum versions before admitting participants.
- Ensuring a certain minimum window size of the window displaying the study so that the minimum size is respected for all browser types and display sizes of participants.
- Automatic exclusion of participants who reload the page once they accepted the consent form, unless configured otherwise.

## How to get started

The template contains two demo studies to get you started. You can switch between different projects by renaming directories: the framework will by default use the project described within the directory 'html/setup/config'. The default study is based on [this work](https://www.aviz.fr/visualcensoring) and the second one is based on [this work](https://aviz.fr/blinded). The default one is an example for a repeated trial experiment (participants see the same base page multiple times with different stimuli) whereas the second example (config-blinded) is an example of a multi-page experiment where all participants go through multiple different pages and where some content on each page can be adjusted depending on the assigned condition.

To get started, either clone this repository, or if you stay within github, use the ''use this template'' function to generate your own version of this repository from which you can then edit. Then start a php server with the main directory of the repo as the root directory (so that index.php is at the base level), and you should be able to view the example project in your browser under an address like [localhost:8080/?debug].

Before starting to make changes, make sure to have read the description of the file system below; especially concerning the directories pages and setup. Comments within the files should help understand how the framework works and how to adapt the existing code to your case.

## How to use this framework
There are four steps to use this framework for the preparation of a study:

1. Generate the pages required, that is, each page shown to a participant needs to have a separate file which should be placed in one of the folders within in html/pages directory. See the file html/pages/questions/attention.php as an example of a page that shows options to participants and logs a response.
1 . Specify the logic of which page follows which by editing the file html/setup/pages_behavior.php
1. Go through the files in the directory html/setup to adjust all parameters to values that make sense for your experiment. If you need to load any javascript required to run your study, then you can do so using the file load_js.php. This file is included after a participant is assigned to a condition and the variable $condition as well as $factor1 (and $factor2 if used) can be used to only load files relevant for the condition to which the participant was assigned. 
1. Test your study design extensively. Locally, you can use a development environment such as [MAMP](https://www.mamp.info/en/downloads/) to serve the study pages and to test whether the logging works as it should. If you use MAMP, set the server directory in the preferences to the base directory of your study, that is, the level at which you can find this read.me file. Then start the server and open the page http://localhost?debug in your browser. The GET parameter ?debug deactivates the reload check and replaces the participant ID in the log files with the name DEBUG.
1. Once you go from debugging to piloting your experiment (that is asking others to try it), use the URL parameter ?pilot instead of ?debug. The only difference is that it will generate a random string for each person accessing the page instead of using DEGBUG for all testers.

Then there are three more steps to get your study to run on Prolific:

1. When all is ready, put your study on the public server that will host it. Then generate a study in Prolific and fill in the constants in the file html/pages/constants.php. Indicate the link to your study in the Prolific platform and check the mark that indicates that you want the standard GET parameters sent to your study. Copy the completion code URL into the constants.php file.
1. Test again using the test link provided in the Prolific platform. Go through the entire study and make sure that the completion code at the end gets you back to the Prolific platform and indicates that everything worked out.
1. Before you run your study, delete all log files generated during the debug phase.


## Description of the directory structure

This framework is meant as a template and structured as follows

- html: All html/php code as well as javascript and css goes here
	- ajax: directory containing php code to log data sent back from participants. There should be no need to edit any of the files in there.
	- components: directory containing reusable components, that is, interface elements such as sliders, notifactions etc.
		- button.php: definition of a button component which is used in the framework to realize the next button at the bottom of the screen. That button sends events that trigger logging of timestamps after each page is completed. Hence, this file shouldn't be edited as it could introduce inconsistencies elsewhere in the framework. Only edit if you know what you are doing.
		- warning.php: definition of a small warning shown at the bottom of a screen, for example, to alert a participants that they may need to scroll to see the entire content shown to them. See the html/pages/instructions/consnt.php for an example use.
	- content.php: The main file that generates the pages shown to the participant. While the experience of the participant is a series of pages showing different content, underneath only one page is loaded and javascript events triggered by buttons control which page to show to the participant at any moment. There should generally be no need to directly edit this file.
	- css: the style directory
		- bootstrap.min.css: for default styling of elements
		- main.css: the custom styling specific to the experiment. If you want to change the default page size, adjust the values at the top of this file.
	- image: directory into which should go all images loaded by any of the web pages.
	- js: javascript directory
		- init-index.js: basic javascript loaded at the beginning, currently only initializes events to check the window size.
		- init-logging.js: sets up the events used for logging.
		- lib: directory with libraries used by the framework
		- tools: javascript tools
		- visualizations: directory to put code relevant for showing visualizations (potentially depending on conditions)
	- page_skeleton.php: the skeleton page used to generate experiment pages. There should be no need to edit this.
	- pages: directory containing the actual php/html pages included in the experiment. There are subdirectories to further sort pages. Put all your code that actually generates a page here. For these files, there is no need to include header etc since all of these pages will be embedded in one large page. See the example pages in there. You can use variables such as $condition (int) to show content depending on the condition a participant was assigned to.
	- setup: The files here define constants and other parameters for your experiment. Go through all files and make sure they correspond to what you need. Most important is to edit the file constants.php and pages_behavior.php.
		- constants.php: Adjust the variables $NUM_CONDITIONS, $FACTORS, and $FACTOR_LEVELS. Once you're ready to run your experiment, you also need to adjust the constants relevant for Prolific. 
		- pages_behavior.php: This file contains all the logic of your experiment. It assigns values to all the parameters defined in the page_skeleton.php and it defines which html code to load from the pages directory. The array $PAGE_ORDER at the bottom also needs to be set. 
- index.php: The landing page. Only basic checks are performed here. The actual page is loaded as an iframe.
- results: directory containing all result files
	- individual: directory containing individual log files for each participant
	- results.csv: Your results will end up in this file. It doesn't exist until at least one person completes the experiment.



## URL parameters

There are a few URL parameters for different purposes such as testing before deploying an experiment. URL parameters are added after the main URL and a ? and can be combined together with the & character. For example localhost?debug&condition=1. Below a list of currently defined URL parameters.

- debug: disables the reload check and the check for the presence of the URL parameters sent by Prolific. Always use this one during the development phase.
- pilot: disables the check for the presence of the URL parameters sent by Prolific. That way, logging works normally (one line for every person loading the page) but you can pilot outside of the Prolific platform.
- condition: this parameter requires a value (e.g., condition=0) and allows to control which factor combination is selected. By default condition is assigned randomly when the page is loaded. This parameter allows to force a specific condition. This is most useful during testing.
- page: this parameter requires a value (e.g., page = 5) and allows to control on which page of the experiment should be displayed when loaded. This is a debugging feature and allows one to immediately see a page one is working on without having to click through all pages.
- PROLIFIC_PID: one of the parameters sent by Prolific (option needs to be enabled when setting up the study on the Prolific platform)
- STUDY_ID: one of the parameters sent by Prolific (option needs to be enabled when setting up the study on the Prolific platform)
- SESSION_ID: one of the parameters sent by Prolific (option needs to be enabled when setting up the study on the Prolific platform)
