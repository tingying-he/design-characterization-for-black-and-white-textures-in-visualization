

################################################################
# Bootstrap CI Helper Functions.
# Computes bootstrap confidence intervals with the sensible defaults.
# 2014 Pierre Dragicevic
# 2018 Anastasia Bezerianos
################################################################

# For more details
# See http://www.mayin.org/ajayshah/KB/R/documents/boot.html for boot
# and (Kirby and Gerlanc, 2013) http://web.williams.edu/Psychology/Faculty/Kirby/bootes-kirby-gerlanc-in-press.pdf for bootES and for referencing the bootstrap method in your paper

library(boot)
library(PropCIs)

# If set to TRUE, bootstrap intervals remain the same across executions.
deterministic <- TRUE

# The number of bootstrap resamples. Typically recommended is >= 1,000.
# The higher the number, the more precise the interval but also the slower
# the computation.
replicates <- 10000

# The method for computing intervals. The adjusted bootstrap
# percentile (BCa) method is recommended by (Kirby and Gerlanc, 2013)
# and should work in most cases. For other methods type help(boot.ci).

# FIXME: changing this does not work
intervalMethod <- "bca"

# Number of significant digits used for text output. Using many digits
# is not recommended as it gives a misleading impression of precision.
significantDigits <- 3

#####################################################################

# Statistics

samplemedian <- function(x, d) {
  return(median(x[d]))
}

samplemean <- function(x, d) {
  return(mean(x[d]))
}

# Data transformations

# No transformation, yields arithmetic means.
identityTransform <- c(
  function(x) {return (x)}, # the transformation
  function(x) {return (x)}, # the inverse transformation
  TRUE                      # TRUE if increasing, FALSE otherwise
)

# Log transformation, yields geometric means.
logTransform <- c(
  function(x) {return (log(x))}, # the transformation
  function(x) {return (exp(x))}, # the inverse transformation
  TRUE                         # TRUE if increasing, FALSE otherwise
)

# Inverse transformation, yields harmonic means.
inverseTransform <- c(
  function(x) {return (1/x)}, # the transformation
  function(x) {return (1/x)}, # the inverse transformation
  FALSE                     # TRUE if increasing, FALSE otherwise
)

# Returns the point estimate and confidence interval in an array of length 3
bootstrapCI <- function(statistic, datapoints) {
  # Compute the point estimate
  pointEstimate <- statistic(datapoints)
  # Make the rest of the code deterministic
  if (deterministic) set.seed(0)
  # Generate bootstrap replicates
  b <- boot(datapoints, statistic, R = replicates, parallel="multicore")
  # Compute interval
  ci <- boot.ci(b, type = intervalMethod)
  # Return the point estimate and CI bounds
  # You can print the ci object for more info and debug
  lowerBound <- ci$bca[4]
  upperBound <- ci$bca[5]
  return(c(pointEstimate, lowerBound, upperBound))
}
bootstrapCI_corr <- function(statistic, datapoints, comparisons) {
  # Compute the point estimate
  pointEstimate <- statistic(datapoints)
  # Make the rest of the code deterministic
  if (deterministic) set.seed(0)
  # Generate bootstrap replicates
  b <- boot(datapoints, statistic, R = replicates, parallel="multicore")
  # Compute interval
  ci <- boot.ci(b, type = intervalMethod)
  level <- 1 - 0.05/comparisons
  ci_corr <- boot.ci(b, type = intervalMethod, conf = level)
  # Return the point estimate and CI bounds
  # You can print the ci object for more info and debug
  lowerBound <- ci$bca[4]
  upperBound <- ci$bca[5]
  lowerBound_corr <- ci_corr$bca[4]
  upperBound_corr <- ci_corr$bca[5]
  return(c(pointEstimate, lowerBound, upperBound, level, lowerBound_corr, upperBound_corr))
}

# Returns the mean and its confidence interval in an array of length 3
bootstrapMeanCI <- function(datapoints) {
  return(bootstrapCI(samplemean, datapoints))
}
bootstrapMeanCI_corr <- function(datapoints, comparisons) {
  return(bootstrapCI_corr(samplemean, datapoints, comparisons))
}

# Returns the median and its confidence interval in an array of length 3
bootstrapMedianCI <- function(datapoints) {
  return(bootstrapCI(samplemedian, datapoints))
}
bootstrapMedianCI_corr <- function(datapoints, comparisons) {
  return(bootstrapCI_corr(samplemedian, datapoints, comparisons))
}

# Returns the mean and its "classical" confidence interval in an array of length 3.
# Uses the t-distribution confidence interval for samples that are approximately normally
# distributed and/or large. Not a bootstrap method but included here for convenience.
exactMeanCI <- function(datapoints, transformation = identityTransform) {
  datapoints <- transformation[[1]](datapoints)
  pointEstimate <- mean(datapoints)
  ttest <- t.test(datapoints)
  lowerBound <- ttest[4]$conf.int[1]
  upperBound <- ttest[4]$conf.int[2]
  if (transformation[[3]])
    return(transformation[[2]](c(pointEstimate, lowerBound, upperBound)))
  else
    return(transformation[[2]](c(pointEstimate, upperBound, lowerBound)))
}

# Returns a percentage and its confidence interval, for binary observations.
# Uses a confidence interval method for proportions. Not a bootstrap method but
# included here for convenience.
percentCI <- function(datapoints, value) {
  ncorrect <- length(datapoints[datapoints == value])
  total <- length(datapoints)
  percent <- 100 * ncorrect / total
  proportionCI <- midPci(x = ncorrect, n = total, conf.level = 0.95)
  percentCIlow <- 100 * proportionCI$conf.int[1]
  percentCIhigh <- 100 * proportionCI$conf.int[2]
  return (c(percent, percentCIlow, percentCIhigh))
}

percentCI_corr <- function(datapoints, value, comparisons) {
  ncorrect <- length(datapoints[datapoints == value])
  total <- length(datapoints)
  percent <- 100 * ncorrect / total
  level <- 1 - 0.05 / comparisons
  proportionCI <- midPci(x = ncorrect, n = total, conf.level = 0.95)
  proportionCI_corr <- midPci(x = ncorrect, n = total, conf.level = level)
  percentCIlow <- 100 * proportionCI$conf.int[1]
  percentCIhigh <- 100 * proportionCI$conf.int[2]
  percentCIlow_corr <- 100 * proportionCI_corr$conf.int[1]
  percentCIhigh_corr <- 100 * proportionCI_corr$conf.int[2]
  return (c(percent, percentCIlow, percentCIhigh, level, percentCIlow_corr, percentCIhigh_corr))
}

# Returns the point estimate and confidence interval in a human-legible text format
bootstrapCI.text <- function(statistic, datapoints, unit) {
  result <- bootstrapCI(statistic, datapoints)
  point <- result[1]
  interval <- c(result[2], result[3])
  # Format results in human-legible format using APA style
  text <- paste(
    prettyNum(point, digits=significantDigits),
    unit,
    ", 95% CI [",
    prettyNum(interval[1], digits=significantDigits),
    unit,
    ", ",
    prettyNum(interval[2], digits=significantDigits),
    unit,
    "]",
    sep = "")
  return(text)
}
bootstrapCI_corr.text <- function(statistic, datapoints, unit, comparisons) {
  result <- bootstrapCI_corr(statistic, datapoints,comparisons)
  point <- result[1]
  interval <- c(result[2], result[3])
  corr_level <- c(results[4])
  interval_corr <- c(result[5], result[6])
  # Format results in human-legible format using APA style
  text <- paste(
    prettyNum(point, digits=significantDigits),
    unit,
    ", 95% CI [",
    prettyNum(interval[1], digits=significantDigits),
    unit,
    ", ",
    prettyNum(interval[2], digits=significantDigits),
    unit,
    "] ... ", 
    corr_level, "% CI [",  
    prettyNum(interval_corr[1], digits=significantDigits),
    unit,
    ", ",
    prettyNum(interval_corr[2], digits=significantDigits),
    unit,
    "]",
    sep = "")
  return(text)
}

# Returns the mean and its confidence interval in a human-legible text format
bootstrapMeanCI.text <- function(datapoints, unit) {
  return(bootstrapCI.text(samplemean, datapoints, unit))
}
bootstrapMeanCI_corr.text <- function(datapoints, unit, comparisons) {
  return(bootstrapCI_corr.text(samplemean, datapoints, unit, comparisons))
}

# Returns the median and its confidence interval in a human-legible text format
bootstrapMedianCI.text <- function(datapoints, unit) {
  return(bootstrapCI.text(samplemedian, datapoints, unit))
}
bootstrapMedianCI_corr.text <- function(datapoints, unit, comparisons) {
  return(bootstrapCI_corr.text(samplemedian, datapoints, unit, comparisons))
}



# 2015--2018 Wesley Willett, Petra Isenberg and Lonni Besancon, Anastasia Bezerianos

library(ggplot2)
library(reshape2)


barChart <- function(resultTable, techniques, nbTechs = -1, ymin, ymax,  gray_line_interval, xAxisLabel = "I am the X axis", yAxisLabel = "I am the Y Label",annotation=""){
  #tr <- t(resultTable)
  if(nbTechs <= 0){
    stop('Please give a positive number of Techniques, nbTechs');
  }

  
  tr <- as.data.frame(resultTable)
  nbTechs <- nbTechs - 1 ; # seq will generate nb+1
  
  #now need to calculate one number for the width of the interval
  tr$CI2 <- tr$upperBound_CI - tr$mean_time
  tr$CI1 <- tr$mean_time - tr$lowerBound_CI
  
  #add a technique column
  tr$technique <- factor(seq.int(0, nbTechs, 1));
  breaks <- c(as.character(tr$technique));
  print(tr)
  g <- ggplot(tr, aes(x=technique, y=mean_time)) + 
 #   geom_bar(stat="identity",fill = I("#CCCCCC")) +
    geom_errorbar(aes(ymin=mean_time-CI1, ymax=mean_time+CI2),
                  width=0,                    # Width of the error bars
                  size = 1.1
    ) +
    #labs(title="Overall time per technique") +
    labs(x = xAxisLabel, y = yAxisLabel) + 
    scale_y_continuous(limits = c(ymin,ymax), breaks = seq(ymin,ymax, gray_line_interval)) +
    scale_x_discrete(name="",breaks,techniques,position = "bottom")+ # bottom: put the techniques label to the left
    coord_flip() +
    theme(panel.background = element_rect(fill = 'white', colour = 'white'),
          #axis.title=element_text(size = rel(1.2), colour = "black"),
          axis.title = element_blank(),
          axis.text=element_text(size = rel(1.2), colour = "black"),
          axis.text.y = element_text(hjust=1),
          panel.grid.major = element_line(colour = "#DDDDDD"),
          panel.grid.major.y = element_blank(),
          axis.ticks = element_blank(),
          panel.grid.minor.y = element_blank())+
    geom_point(size=2, colour="black")         # dots
    #geom_label(aes(y=0,x=nbTechs+1, label = annotation),hjust=0.5,label.padding= unit(0.4, "lines"), vjust = 0.5, nudge_y = ymin+(0.025*(ymax-ymin)), label.size = 0, colour = "white", fill = "pink", inherit.aes=FALSE, alpha=.8,size=rel(8))

  print(g)
}


barChart_corr <- function(resultTable, techniques, nbTechs = -1, ymin, ymax, gray_line_interval, xAxisLabel = "I am the X axis", yAxisLabel = "I am the Y Label",annotation=""){

  if(nbTechs <= 0){
    stop('Please give a positive number of Techniques, nbTechs');
  }
  
  tr <- as.data.frame(resultTable)
  nbTechs <- nbTechs - 1 ; # seq will generate nb+1
  
  #now need to calculate one number for the width of the interval
  tr$CI2 <- tr$upperBound_CI - tr$mean_time
  tr$CI1 <- tr$mean_time - tr$lowerBound_CI

  tr$CI2_corr <- tr$upperBound_CI_corr - tr$mean_time
  tr$CI1_corr <- tr$mean_time - tr$lowerBound_CI_corr
  
  #add a technique column
  tr$technique <- factor(seq.int(0, nbTechs, 1));
  
  
  breaks <- c(as.character(tr$technique));
  print(tr)
  g <- ggplot(tr, aes(x=technique, y=mean_time)) + 
    #   geom_bar(stat="identity",fill = I("#CCCCCC")) +
    geom_errorbar(aes(ymin=mean_time-CI1_corr, ymax=mean_time+CI2_corr),
                  width=0.1,                    # Width of the error bars
                  size = 0.5,
                  color = "red"
    ) +
    geom_errorbar(aes(ymin=mean_time-CI1, ymax=mean_time+CI2),
                  width=0,                    # Width of the error bars
                  size = 1.1
    ) +
    #labs(title="Overall time per technique") +
    labs(x = xAxisLabel, y = yAxisLabel) + 
    scale_y_continuous(limits = c(ymin,ymax), breaks = seq(ymin,ymax, gray_line_interval)) +
    scale_x_discrete(name="",breaks,techniques,position = "bottom")+
    coord_flip() +
    theme(panel.background = element_rect(fill = 'white', colour = 'white'),
          #axis.title=element_text(size = rel(1.2), colour = "black"),
          axis.title = element_blank(),
          axis.text=element_text(size = rel(1.2), colour = "black"),
          axis.text.y = element_text(hjust=1),
          panel.grid.major = element_line(colour = "#DDDDDD"),
          panel.grid.major.y = element_blank(), 
          axis.ticks = element_blank(),
          panel.grid.minor.y = element_blank())+
          geom_point(size=2, colour="black")         # dots
    #geom_label(aes(y=0,x=nbTechs+1, label = annotation),hjust=0.5,label.padding= unit(0.4, "lines"), vjust = 0.5, nudge_y = ymin+(0.025*(ymax-ymin)), label.size = 0, colour = "white", fill = "pink", inherit.aes=FALSE, alpha=.8,size=rel(8))
  print(g)
}


