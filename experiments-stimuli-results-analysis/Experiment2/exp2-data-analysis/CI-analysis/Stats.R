library(plyr)
library(dplyr)
library(tidyr)

source("CI-Functions-Bonferroni.R")


mydata <- read.table("exp-data/beauvis.csv", header=T, sep=",")
filename_analysis <- "results/"

##Need to refactor the data a bit

#This was a between-subjects experiment
bardf <- mydata %>% select(matches("bar|participant_id"))
bardf <- bardf %>% drop_na(beauvis_bar_geo)
bardf <- bardf %>% 
  rename(
    geometric = beauvis_bar_geo,
    iconic = beauvis_bar_icon,
    unicolor = beauvis_bar_color
  )

piedf <- mydata %>% select(matches("pie|participant_id"))
piedf <- piedf %>% drop_na(beauvis_pie_geo)
piedf <- piedf %>% 
  rename(
    geometric = beauvis_pie_geo,
    iconic = beauvis_pie_icon,
    unicolor = beauvis_pie_color
  )


##Calculating threshold CIs for the bar charts
technique_bar_geo <- bootstrapMeanCI(bardf$geometric)
technique_bar_icon <- bootstrapMeanCI(bardf$iconic)
technique_bar_unicolor <- bootstrapMeanCI(bardf$unicolor)

##Calculating threshold CIs for the pie charts
technique_pie_geo <- bootstrapMeanCI(piedf$geometric)
technique_pie_icon <- bootstrapMeanCI(piedf$iconic)
technique_pie_unicolor <- bootstrapMeanCI(piedf$unicolor)


###changing the data structure a bit
#bar chart
barData <- c()
barData$name <- c("geometric","iconic","unicolor")
barData$pointEstimate <- c(technique_bar_geo[1], technique_bar_icon[1],technique_bar_unicolor[1])
barData$ci.max <- c(technique_bar_geo[3], technique_bar_icon[3],technique_bar_unicolor[3])
barData$ci.min <- c(technique_bar_geo[2], technique_bar_icon[2],technique_bar_unicolor[2])

#pie chart
pieData <- c()
pieData$name <- c("geometric","iconic","unicolor")
pieData$pointEstimate <- c(technique_pie_geo[1], technique_pie_icon[1],technique_pie_unicolor[1])
pieData$ci.max <- c(technique_pie_geo[3], technique_pie_icon[3],technique_pie_unicolor[3])
pieData$ci.min <- c(technique_pie_geo[2], technique_pie_icon[2],technique_pie_unicolor[2])

##preparting to print
#bar chart
#bardatatoprint <- data.frame(factor(barData$name),barData$pointEstimate, barData$ci.min, barData$ci.max)
#colnames(bardatatoprint) <- c("technique", "time", "lowerBound_CI", "upperBound_CI ")

#pie chart
#piedatatoprint <- data.frame(factor(pieData$name),pieData$pointEstimate, pieData$ci.min, pieData$ci.max)
#colnames(piedatatoprint) <- c("technique", "time", "lowerBound_CI", "upperBound_CI ")


####plotting
#bar chart
bardatatoprint <- data.frame(factor(barData$name),barData$pointEstimate, barData$ci.min, barData$ci.max)
colnames(bardatatoprint) <- c("technique", "mean_time", "lowerBound_CI", "upperBound_CI ")
gbar <- barChart(bardatatoprint,barData$name ,nbTechs = 3, ymin = 1, ymax = 7, gray_line_interval = 1, "", "","") #Avg. Thresholds. Error Bars, Bootstrap 95% CIs
print(gbar)

fname <- "results/beauvis_bar.pdf"
ggsave(filename = fname, plot=gbar, width = 8, height= 1.8, device= pdf(), units = "in")
dev.off()

tmp <- paste(filename_analysis, "beauvis_bar.csv", collapse="_")
write.csv(bardatatoprint,file=tmp)



#pie chart
piedatatoprint <- data.frame(factor(pieData$name),pieData$pointEstimate, pieData$ci.min, pieData$ci.max)
colnames(piedatatoprint) <- c("technique", "mean_time", "lowerBound_CI", "upperBound_CI ")
gpie <- barChart(piedatatoprint,pieData$name ,nbTechs = 3, ymin = 1, ymax = 7, gray_line_interval = 1,"", "","") #Avg. Thresholds. Error Bars, Bootstrap 95% CIs
print(gpie)
fname <- "results/beauvis_pie.pdf"
ggsave(filename = fname, plot=gpie, width = 8, height= 1.8, device= pdf(), units = "in")
dev.off()

tmp <- paste(filename_analysis, "beauvis_pie.csv", collapse="_")
write.csv(piedatatoprint,file=tmp)

########################

# CIs with adapted alpha value for multiple comparisons --- calculate the differences between techniques for each chart separately
diff_geo_icon_bar = bootstrapMeanCI_corr(bardf$geometric  - bardf$iconic, 3)
diff_geo_uni_bar  = bootstrapMeanCI_corr(bardf$geometric  - bardf$unicolor, 3)
diff_uni_icon_bar = bootstrapMeanCI_corr(bardf$unicolor - bardf$iconic, 3)

diff_geo_icon_pie = bootstrapMeanCI_corr(piedf$geometric  - piedf$iconic, 3)
diff_geo_uni_pie  = bootstrapMeanCI_corr(piedf$geometric  - piedf$unicolor, 3)
diff_uni_icon_pie = bootstrapMeanCI_corr(piedf$unicolor - piedf$iconic, 3)


analysisBar <- c()
analysisBar$name <- c("geo-icon", "geo-uni", "uni-icon")
analysisBar$pointEstimate <- c(diff_geo_icon_bar[1], diff_geo_uni_bar[1], diff_uni_icon_bar[1])
analysisBar$ci.max <- c(diff_geo_icon_bar[3], diff_geo_uni_bar[3], diff_uni_icon_bar[3])
analysisBar$ci.min <- c(diff_geo_icon_bar[2], diff_geo_uni_bar[2], diff_uni_icon_bar[2])
analysisBar$level  <- c(diff_geo_icon_bar[4], diff_geo_uni_bar[4], diff_uni_icon_bar[4])
analysisBar$ci_corr.max <- c(diff_geo_icon_bar[6], diff_geo_uni_bar[6], diff_uni_icon_bar[6])
analysisBar$ci_corr.min <- c(diff_geo_icon_bar[5], diff_geo_uni_bar[5], diff_uni_icon_bar[5])

analysisPie <- c()
analysisPie$name <- c("geo-icon", "geo-uni", "uni-icon")
analysisPie$pointEstimate <- c(diff_geo_icon_pie[1], diff_geo_uni_pie[1], diff_uni_icon_pie[1])
analysisPie$ci.max <- c(diff_geo_icon_pie[3], diff_geo_uni_pie[3], diff_uni_icon_pie[3])
analysisPie$ci.min <- c(diff_geo_icon_pie[2], diff_geo_uni_pie[2], diff_uni_icon_pie[2])
analysisPie$level  <- c(diff_geo_icon_pie[4], diff_geo_uni_pie[4], diff_uni_icon_pie[4])
analysisPie$ci_corr.max <- c(diff_geo_icon_pie[6], diff_geo_uni_pie[6], diff_uni_icon_pie[6])
analysisPie$ci_corr.min <- c(diff_geo_icon_pie[5], diff_geo_uni_pie[5], diff_uni_icon_pie[5])


###Plotting the differences

#Bar chart
datatoprintbar <- data.frame(factor(analysisBar$name), analysisBar$pointEstimate, analysisBar$ci.min, analysisBar$ci.max, analysisBar$level, analysisBar$ci_corr.min, analysisBar$ci_corr.max)
colnames(datatoprintbar) <- c("technique", "mean_time", "lowerBound_CI", "upperBound_CI", "corrected_CI", "lowerBound_CI_corr", "upperBound_CI_corr") #We use the name mean_time for the value of the mean even though it's not a time, it's just to parse the data for the plot
g <- barChart_corr(datatoprintbar,analysisBar$name ,nbTechs = 3, ymin = -3, ymax = 3,  gray_line_interval = 1,"", "","") #Avg. Thresholds. Error Bars, Bootstrap 95% CIs
print(g)

fname <- "results/beauvis_diff_bar.pdf"
ggsave(filename = fname, plot=g, width = 8, height= 1.8, device= pdf(), units = "in")
dev.off()

tmp <- paste(filename_analysis, "beauvis_diff_bar.csv", collapse="_")
write.csv(datatoprintbar,file=tmp)

#Pie chart
datatoprintpie <- data.frame(factor(analysisPie$name), analysisPie$pointEstimate, analysisPie$ci.min, analysisPie$ci.max, analysisPie$level, analysisPie$ci_corr.min, analysisPie$ci_corr.max)
colnames(datatoprintpie) <- c("technique", "mean_time", "lowerBound_CI", "upperBound_CI", "corrected_CI", "lowerBound_CI_corr", "upperBound_CI_corr") #We use the name mean_time for the value of the mean even though it's not a time, it's just to parse the data for the plot
g <- barChart_corr(datatoprintpie,analysisPie$name ,nbTechs = 3, ymin = -3, ymax = 3,  gray_line_interval = 1, "", "","") #Avg. Thresholds. Error Bars, Bootstrap 95% CIs
print(g)

fname <- "results/beauvis_diff_pie.pdf"
ggsave(filename = fname, plot=g, width = 8, height= 1.8, device= pdf(), units = "in")
dev.off()

tmp <- paste(filename_analysis, "beauvis_diff_pie.csv", collapse="_")
write.csv(datatoprintpie,file=tmp)


