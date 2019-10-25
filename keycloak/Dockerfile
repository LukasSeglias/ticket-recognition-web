FROM jboss/keycloak

USER root

# Install dos2unix
RUN yum -y update && \
	yum -y upgrade && \
    yum -y install dos2unix

# Entrypoint
COPY docker-entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh && \
    dos2unix /entrypoint.sh

# Config import script
COPY config-import.sh /opt/config-import.sh
RUN chmod +x /opt/config-import.sh && \
    dos2unix /opt/config-import.sh

# Configuration
COPY config $JBOSS_HOME/config
RUN chmod -R +x $JBOSS_HOME/config/*.sh && \
    find $JBOSS_HOME/config/ -type f -print0 | xargs -0 dos2unix

# Permissions
RUN chgrp -R 0 $JBOSS_HOME && \
    chmod -R g=u $JBOSS_HOME && \
    chmod -R g=u /etc/passwd

USER 1000

EXPOSE 8080

ENTRYPOINT [ "/entrypoint.sh" ]