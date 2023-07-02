library(plyr)
library(dplyr)
library(tidyr)

source("CI-Functions-Bonferroni.R")
mydata <- read.table("exp2_pie.csv", header=T, sep=",")
filename_analysis <- "results/"

##Need to refactor the data a bit

#This was a between-subjects experiment
piedf <- mydata %>% select(matches("pie|participant_id"))
piedf <- piedf %>% drop_na(vibratory_pie_geo)
piedf <- piedf %>% 
  rename(
    geometric = vibratory_pie_geo,
    iconic = vibratory_pie_icon,
    #unicolor = vibratory_pie_color
  )


##Calculating threshold CIs for the pie charts
technique_pie_geo <- bootstrapMeanCI(piedf$geometric)
technique_pie_icon <- bootstrapMeanCI(piedf$iconic)
#technique_pie_unicolor <- bootstrapMeanCI(piedf$unicolor)


###changing the data structure a bit
#pie chart
pieData <- c()
pieData$name <- c("geometric","iconic")
pieData$pointEstimate <- c(technique_pie_geo[1], technique_pie_icon[1])
pieData$ci.max <- c(technique_pie_geo[3], technique_pie_icon[3])
pieData$ci.min <- c(technique_pie_geo[2], technique_pie_icon[2])


##preparting to print
#pie chart
#piedatatoprint <- data.frame(factor(pieData$name),pieData$pointEstimate, pieData$ci.min, pieData$ci.max)
#colnames(piedatatoprint) <- c("technique", "time", "lowerBound_CI", "upperBound_CI ")

#pie chart
#piedatatoprint <- data.frame(factor(pieData$name),pieData$pointEstimate, pieData$ci.min, pieData$ci.max)
#colnames(piedatatoprint) <- c("technique", "time", "lowerBound_CI", "upperBound_CI ")


####plotting
#pie chart
piedatatoprint <- data.frame(factor(pieData$name),pieData$pointEstimate, pieData$ci.min, pieData$ci.max)
colnames(piedatatoprint) <- c("technique", "mean_time", "lowerBound_CI", "upperBound_CI ")
gpie <- barChart(piedatatoprint,pieData$name ,nbTechs = 2, ymin = 1, ymax = 7, gray_line_interval = 1, "", "","pie") #Avg. Thresholds. Error pies, Bootstrap 95% CIs
print(gpie)

fname <- "results/exp2_vibratory_pie.pdf"
ggsave(filename = fname, plot=gpie, width = 8, height= 0.8, device= pdf(), units = "in")
dev.off()

tmp <- paste(filename_analysis, "exp2_vibratory_pie.csv", collapse="_")
write.csv(piedatatoprint,file=tmp)


########################

# CIs with adapted alpha value for multiple comparisons --- calculate the differences between techniques for each chart separately
diff_geo_icon_pie = bootstrapMeanCI_corr(piedf$geometric  - piedf$iconic, 1)
#diff_geo_uni_pie  = bootstrapMeanCI_corr(piedf$geometric  - piedf$unicolor, 3)
#diff_uni_icon_pie = bootstrapMeanCI_corr(piedf$unicolor - piedf$iconic, 3)


analysispie <- c()
#analysisPie$name <- c("geo-icon", "geo-uni", "uni-icon")
analysisPie$name <- c("geo-icon")
analysisPie$pointEstimate <- c(diff_geo_icon_pie[1])
analysisPie$ci.max <- c(diff_geo_icon_pie[3])
analysisPie$ci.min <- c(diff_geo_icon_pie[2])
analysisPie$level  <- c(diff_geo_icon_pie[4])
analysisPie$ci_corr.max <- c(diff_geo_icon_pie[6])
analysisPie$ci_corr.min <- c(diff_geo_icon_pie[5])


###Plotting the differences

#Pie chart
datatoprintpie <- data.frame(factor(analysisPie$name), analysisPie$pointEstimate, analysisPie$ci.min, analysisPie$ci.max, analysisPie$level, analysisPie$ci_corr.min, analysisPie$ci_corr.max)
colnames(datatoprintpie) <- c("technique", "mean_time", "lowerBound_CI", "upperBound_CI", "corrected_CI", "lowerBound_CI_corr", "upperBound_CI_corr") #We use the name mean_time for the value of the mean even though it's not a time, it's just to parse the data for the plot
g <- barChart_corr(datatoprintpie,analysisPie$name ,nbTechs = 1, ymin = -3, ymax = 3, gray_line_interval = 1, "", "","pie") #Avg. Thresholds. Error Bars, Bootstrap 95% CIs
print(g)

fname <- "results/exp2_vibratory_diff_pie.pdf"
ggsave(filename = fname, plot=g, width = 8, height= 0.6, device= pdf(), units = "in")
dev.off()

tmp <- paste(filename_analysis, "exp2_vibratory_diff_pie.csv", collapse="_")
write.csv(datatoprintpie,file=tmp)

