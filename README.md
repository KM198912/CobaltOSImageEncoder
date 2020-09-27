# CobaltOSImageEncoder
A quick and dirty image encoder and compressor written in PHP. Takes png or jpg and makes into base64 gzdeflated string. 64x64 image is ~ 6000 characters. NOTE: THIS OUTPUTS A CUSTOM IMAGE FORMAT USED FOR COBALTOS. IT IS NOT PURELY A BASE64 ENCODED IMAGE. The format is (w),(h);(csv list r pixels);(csv list g pixels);(csv list b pixels)
