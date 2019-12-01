FROM ubuntu:18.04

RUN apt-get -y update && apt-get install -y

# Install packages necessary to run EAP
RUN apt-get -y install xmlstarlet libsaxon-java augeas-tools bsdtar unzip && apt-get clean all

# Create a user and group used to launch processes
# The user ID 1000 is the default for the first "regular" user on Fedora/RHEL,
# so there is a high chance that this ID will be equal to the current user
# making it easier to use volumes (no permission issues)
RUN groupadd -r jboss -g 1000 && useradd -u 1000 -r -g jboss -m -d /opt/jboss -s /sbin/nologin -c "JBoss user" jboss && \
    chmod 755 /opt/jboss

# Set the working directory to jboss' user home directory
WORKDIR /opt/jboss

# User root user to install software
USER root

# Install necessary packages
RUN apt-get -y update && apt-get install -y openjdk-8-jdk && apt-get install -y curl

# Switch back to jboss user
USER jboss

# Set the JAVA_HOME variable to make it clear where Java is located
ENV JAVA_HOME /usr/lib/jvm/java-8-openjdk-amd64/

# Set the WILDFLY_VERSION env variable
ENV WILDFLY_VERSION 18.0.1.Final
ENV WILDFLY_SHA1 ef0372589a0f08c36b15360fe7291721a7e3f7d9
ENV JBOSS_HOME /opt/jboss/wildfly

USER root

# Add the WildFly distribution to /opt, and make wildfly the owner of the extracted tar content
# Make sure the distribution is available from a well-known place
RUN cd $HOME \
    && curl -O https://download.jboss.org/wildfly/$WILDFLY_VERSION/wildfly-$WILDFLY_VERSION.tar.gz \
    && sha1sum wildfly-$WILDFLY_VERSION.tar.gz | grep $WILDFLY_SHA1 \
    && tar xf wildfly-$WILDFLY_VERSION.tar.gz \
    && mv $HOME/wildfly-$WILDFLY_VERSION $JBOSS_HOME \
    && rm wildfly-$WILDFLY_VERSION.tar.gz \
    && chown -R jboss:0 ${JBOSS_HOME} \
    && chmod -R g+rw ${JBOSS_HOME}

# Ensure signals are forwarded to the JVM process correctly for graceful shutdown
ENV LAUNCH_JBOSS_IN_BACKGROUND true

USER jboss

# Expose the ports we're interested in
EXPOSE 8080

# Set the default command to run on boot
# This will boot WildFly in the standalone mode and bind to all interface
CMD ["/opt/jboss/wildfly/bin/standalone.sh", "-b", "0.0.0.0"]

ENV KEYCLOAK_VERSION 7.0.0

USER 1000
WORKDIR $JBOSS_HOME

RUN curl -s -O https://downloads.jboss.org/keycloak/$KEYCLOAK_VERSION/adapters/keycloak-oidc/keycloak-wildfly-adapter-dist-$KEYCLOAK_VERSION.tar.gz \
    && tar xf keycloak-wildfly-adapter-dist-$KEYCLOAK_VERSION.tar.gz \
    && ./bin/jboss-cli.sh --file=./bin/adapter-elytron-install-offline.cli \
    && rm -rf /opt/jboss/wildfly/standalone/configuration/standalone_xml_history \
    && rm keycloak-wildfly-adapter-dist-$KEYCLOAK_VERSION.tar.gz

ADD dist/cli /opt/jboss/wildfly/cli
RUN ./bin/jboss-cli.sh --file=cli/app-standalone-config.cli \
    && rm -rf /opt/jboss/wildfly/standalone/configuration/standalone_xml_history

USER root
RUN apt-get -y update && apt-get -y install dos2unix
COPY src/main/resources/imported/libs/linux/ /usr/local/lib/
RUN dos2unix /usr/local/lib/* && \
    mv /usr/local/lib/* /usr/lib/

COPY src/main/resources/imported/tessdata/ /usr/local/resources/tessdata/
ENV TESSDATA_PREFIX=/usr/local/resources/tessdata/

RUN chgrp -R 0 $JBOSS_HOME && \
    chmod -R g=u $JBOSS_HOME

RUN chmod -R 777 /usr/lib/

USER 1000

ADD build/libs/web-*.war /opt/jboss/wildfly/standalone/deployments/