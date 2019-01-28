export THEOS=/toolchain4/theos
export SDKBINPATH=/toolchain4/pre/bin
export SYSROOT=/toolchain4/sys
export TARGET_CXX=clang -ccc-host-triple arm-apple-darwin9

GO_EASY_ON_ME = 1 
TOOL_NAME = test
test_OBJC_FILES = main.m Downloader.m device.m
test_FRAMEWORKS = UIKit Foundation
include /toolchain4/theos/makefiles/common.mk 
include /toolchain4/theos/makefiles/tool.mk
