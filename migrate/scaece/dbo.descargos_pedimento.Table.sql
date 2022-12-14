/****** Object:  Table [dbo].[descargos_pedimento]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[descargos_pedimento](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[descargos_id] [int] NULL,
	[tipo] [varchar](2) NULL,
	[patente] [varchar](4) NULL,
	[pedimento] [varchar](7) NULL,
	[seccion] [varchar](3) NULL,
	[licencia] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
