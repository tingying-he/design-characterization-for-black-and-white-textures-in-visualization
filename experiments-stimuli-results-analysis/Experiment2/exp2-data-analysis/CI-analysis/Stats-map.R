library(plyr)
library(dplyr)
library(tidyr)

source("CI-Functions-Bonferroni.R")
mydata <- read.table("exp-data/exp2_map.csv", header=T, sep=",")
filename_analysis <- "results/"

##Need to refactor the data a bit

#This was a between-subjects experiment
mapdf <- mydata %>% select(matches("map|participant_id"))
mapdf <- mapdf %>% drop_na(beauvis_map_geo)
mapdf <- mapdf %>% 
  rename(
    geometric = beauvis_map_geo,
    iconic = beauvis_map_icon,
    #unicolor = beauvis_map_color
  )


##Calculating threshold CIs for the map charts
technique_map_geo <- bootstrapMeanCI(mapdf$geometric)
technique_map_icon <- bootstrapMeanCI(mapdf$iconic)
#technique_map_unicolor <- bootstrapMeanCI(mapdf$unicolor)


###changing the data structure a bit
#map chart
mapData <- c()
mapData$name <- c("geometric","iconic")
mapData$pointEstimate <- c(technique_map_geo[1], technique_map_icon[1])
mapData$ci.max <- c(technique_map_geo[3], technique_map_icon[3])
mapData$ci.min <- c(technique_map_geo[2], technique_map_icon[2])


##preparting to print
#map chart
#mapdatatoprint <- data.frame(factor(mapData$name),mapData$pointEstimate, mapData$ci.min, mapData$ci.max)
#colnames(mapdatatoprint) <- c("technique", "time", "lowerBound_CI", "upperBound_CI ")

#map chart
#mapdatatoprint <- data.frame(factor(mapData$name),mapData$pointEstimate, mapData$ci.min, mapData$ci.max)
#colnames(mapdatatoprint) <- c("technique", "time", "lowerBound_CI", "upperBound_CI ")


####plotting
#map chart
mapdatatoprint <- data.frame(factor(mapData$name),mapData$pointEstimate, mapData$ci.min, mapData$ci.max)
colnames(mapdatatoprint) <- c("technique", "mean_time", "lowerBound_CI", "upperBound_CI ")
gmap <- barChart(mapdatatoprint,mapData$name ,nbTechs = 2, ymin = 1, ymax = 7, gray_line_interval = 1, "", "","map") #Avg. Thresholds. Error maps, Bootstrap 95% CIs
print(gmap)

fname <- "results/exp2_beauvis_map.pdf"
ggsave(filename = fname, plot=gmap, width = 8, height= 0.8, device= pdf(), units = "in")
dev.off()

tmp <- paste(filename_analysis, "exp2_beauvis_map.csv", collapse="_")
write.csv(mapdatatoprint,file=tmp)


########################

# CIs with adapted alpha value for multiple comparisons --- calculate the differences between techniques for each chart separately
diff_geo_icon_map = bootstrapMeanCI_corr(mapdf$geometric  - mapdf$iconic, 1)
#diff_geo_uni_map  = bootstrapMeanCI_corr(mapdf$geometric  - mapdf$unicolor, 3)
#diff_uni_icon_map = bootstrapMeanCI_corr(mapdf$unicolor - mapdf$iconic, 3)


analysisMap <- c()
#analysisMap$name <- c("geo-icon", "geo-uni", "uni-icon")
analysisMap$name <- c("geo-icon")
analysisMap$pointEstimate <- c(diff_geo_icon_map[1])
analysisMap$ci.max <- c(diff_geo_icon_map[3])
analysisMap$ci.min <- c(diff_geo_icon_map[2])
analysisMap$level  <- c(diff_geo_icon_map[4])
analysisMap$ci_corr.max <- c(diff_geo_icon_map[6])
analysisMap$ci_corr.min <- c(diff_geo_icon_map[5])


###Plotting the differences

#Map chart
datatoprintmap <- data.frame(factor(analysisMap$name), analysisMap$pointEstimate, analysisMap$ci.min, analysisMap$ci.max, analysisMap$level, analysisMap$ci_corr.min, analysisMap$ci_corr.max)
colnames(datatoprintmap) <- c("technique", "mean_time", "lowerBound_CI", "upperBound_CI", "corrected_CI", "lowerBound_CI_corr", "upperBound_CI_corr") #We use the name mean_time for the value of the mean even though it's not a time, it's just to parse the data for the plot
g <- barChart_corr(datatoprintmap,analysisMap$name ,nbTechs = 1, ymin = -3, ymax = 3, gray_line_interval = 1, "", "","map") #Avg. Thresholds. Error Bars, Bootstrap 95% CIs
print(g)

fname <- "results/exp2_beauvis_diff_map.pdf"
ggsave(filename = fname, plot=g, width = 8, height= 0.6, device= pdf(), units = "in")
dev.off()

tmp <- paste(filename_analysis, "exp2_beauvis_diff_map.csv", collapse="_")
write.csv(datatoprintmap,file=tmp)

